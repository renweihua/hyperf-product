<?php
declare(strict_types = 1);

namespace App\Job\QueryLists;

use App\Model\Article\Article;
use App\Model\FileModel;
use App\Model\Upload\UploadFile;
use Hyperf\AsyncQueue\Job;
use QL\Ext\AbsoluteUrl;
use QL\QueryList;

class CnpscyBlogJob extends Job
{
    public $params;

    /**
     * 任务执行失败后的重试次数，即最大执行次数为 $maxAttempts+1 次
     *
     * @var int
     */
    protected $maxAttempts = 2;

    public function __construct($params)
    {
        // 这里最好是普通数据，不要使用携带 IO 的对象，比如 PDO 对象
        $this->params = $params;

        // $this->file_model = UploadFile::getInstance();
    }

    const URL           = 'https://blog.cnpscy.cn';

    const ARTICLES_LIST = self::URL . '/articles';

    private $file_model;

    public function handle()
    {
        var_dump('handle - 开始爬取{小丑路人}数据：' . date('Y-m-d H:i:s'));;
        var_dump('-------------------------------------------');
        $page = 1;
        $key = 1;
        // 根据参数处理具体逻辑
        $list = true;
        $article_model = Article::getInstance();
        // 通过具体参数获取模型等
        while(!empty($list)){
            $list = $this->getArticles($page);
            foreach ($list as $item) {
                var_dump('第' . $key . '条文章：' . $item['article_title']);
                // 检测文章标题是否已存在，不存在录入
                if (!$article_model->getArticleByTitle($item['article_title'])) {
                    // 文章记录
                    $article = $article_model->add([
                                                       'article_title' => $item['article_title'],
                                                       'article_keywords' => $item['article_title'],
                                                       'article_description' => $item['article_title'],
                                                       'article_origin' => $item['article_origin'],
                                                       'article_author' => $item['article_author'],
                                                       'read_num' => $item['read_num'],
                                                       'created_time' => strtotime($item['created_date']),
                                                       'updated_time' => strtotime($item['updated_date']),]);

                    // 录入文章详情记录
                    $article->content()->create([
                                                    'article_id' => $article->article_id,
                                                    'article_content' => $item['article_content'],
                                                ]);
                }
                ++$key;
            }
            // 页码自动自增，查询下一页数据
            ++$page;
        }
        var_dump('-------------------------------------------');
        var_dump('handle - 结束：' . date('Y-m-d H:i:s'));
    }

    private function getArticlesPageUrl(int $page = 1)
    {
        return self::ARTICLES_LIST . '?page=' . $page;
    }

    public function getArticles(int $page = 1)
    {
        $rules = [// 采集文章标题
            'article_title' => ['a.title', 'text'], // 采集文章作者
            'article_author' => ['img', 'alt'], // 采集文章作者头像
            'author_img' => ['img', 'src'], // 采集文章作者头像
            'article_link' => ['a.title', 'href'], // 详情链接
            'article_origin' => ['a.title', 'href'], // 文章来源
            'created_date' => ['div.date>a', 'data-tooltip'], // 文章的创建时间
            'read_num' => ['div.date>a:eq(-1)', 'text'], // 浏览量
        ];
        $url = $this->getArticlesPageUrl($page);
        $query_list = QueryList::getInstance()
                               ->get($url, null, ['headers' => ['User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Safari/537.36', 'Accept-Encoding' => 'gzip, deflate, br',]])
                               ->rules($rules);
        // 转换URL相对路径到绝对路径 扩展包
        $query_list->use(AbsoluteUrl::class);
        // 用于切分数组的标识（加入是列表：每条数据的标识）
        $range = 'div.event';
        // 文件模型
        $file_model = $this->file_model;
        $host_url = self::URL;
        // 图片资源下载
        //        $query_list->bind('downloadImage',function () use ($file_model, $query_list, $host_url){
        //            $data = $this->query()->getData()->map(function ($item) use ($file_model, $query_list, $host_url){
        //                // 使用帮助函数单独转换某个链接
        //                $item['author_img'] = $query_list->absoluteUrlHelper($host_url, $item['author_img']);
        //                // 获取图片资源信息
        //                $local_file_info = getimagesize($item['author_img']);
        //                // 生成文件名
        //                $local_file_name = $file_model->getUniqidName();
        //                // 获取图片资源，并保存图片到本地路径
        //                file_put_contents($file_model->getAbsolutePath($local_file_name), file_get_contents($item['author_img']));
        //                // 图片录入数据表
        //                $item['file'] = $file_model->addRecordInfo($file_model->getFilePath($local_file_name), $local_file_info['bits'], $local_file_info['mime']);
        //                return $item;
        //            });
        //            //更新data属性
        //            $this->setData($data);
        //            return $this;
        //        });
        //        ->downloadImage()
        $list = $query_list->range($range)->queryData(function ($item) use ($query_list) {
            //使用帮助函数单独转换某个链接
            $item['author_img'] = $query_list->absoluteUrlHelper(self::URL, $item['author_img']);
            // 阅读量
            $item['read_num'] = preg_replace('/[^\d]*/', '', $item['read_num']);
            // 获取文章详情
            $detail = $query_list::get($item['article_link'])
                                 ->rules(['updated_date' => ['div.book-article-meta>a:eq(-1)', 'data-tooltip'], 'content' => ['div.content-body', 'html'],])
                                 ->range('div.extra-padding')
                                 ->queryData()[0] ?? [];
            $item['updated_date'] = $detail['updated_date'] ?? $detail['created_date'];
            $item['article_content'] = $detail['content'] ?? '';
            unset($detail);
            return $item;
        });
        // 释放资源，销毁内存占用
        QueryList::destructDocuments();
        return $list;
    }
}
