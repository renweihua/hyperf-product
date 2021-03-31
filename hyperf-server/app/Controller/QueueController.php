<?php

declare(strict_types = 1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Controller;

use App\Job\QueryListJob;
use App\Job\QueryLists\CnpscyBlogJob;
use App\Job\QueryLists\Win4000;
use App\Model\Rabc\Admin;
use App\Service\QueueService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;

/**
 * @Controller()
 */
class QueueController extends AbstractController
{
    /**
     * @Inject
     * @var QueueService
     */
    protected $service;

    /**
     * 传统模式投递消息
     */
    /**
     * @RequestMapping(path="index", methods="get,post")
     */
    public function index()
    {
        $date = date('Y-m-d H:i:s');
        $text = $this->getRndWords();
        $this->service->push(new CnpscyBlogJob([$text, time()]));
        return 'success --- ' . $date;
        exit;
        for ($i = 0; $i < 1000; $i++){
            $text = $this->getRndWords();

            if (rand(0, 1)){
                $this->service->push(new CnpscyBlogJob([$text, time()]));
            }else{
                $this->service->push(new QueryListJob([$text, time()]));
            }
        }
        return 'success --- ' . $date;
    }

    public function win4000()
    {
        if ($tag_id = $this->request->input('tag_id', 0)) {
            $this->service->push(new Win4000([
                                                 'crawling_urls' => 'http://www.win4000.com/meinvtag' . $tag_id . '_1.html',
                                             ]));

            return 'URL set successfully, please wait patiently --- success --- ' . date('Y-m-d H:i:s');
        }
    }

    private function getRndWords( $giveStr="", $num=18 ){
        $str = "听见啦金玉良缘冰清玉洁继往开来锦绣山河冰 珠帘玉璧倾佳人， 雪聪明功成名就桃花潭水深千尺不及汪伦送我情先帝创业未半而中道今天下三分益州疲弊此诚危急存亡之秋也然侍卫之臣不懈于内忠志之士忘身于外者盖追先帝之殊遇欲报之于陛下也诚宜开张圣听";//字库
        $newStr = "";//机生成的包含答案的字符串
        $anLo = array();//设定的答案所在的位置。
        $bit = 3;//位数，在本系统中是utf-8编码，一个中文长度为3
        $anLenth = floor(strlen($giveStr)/$bit); //答案长度,在UTF编码中，
        //这些汉字在18个汉字中的位置
        $i = 0;
        while ( $i<$anLenth ) {
            $rd = rand( 0, $num-1 );
            if(in_array($rd,$anLo)) continue; //保证了不重复。
            $anLo[] = $rd;
            $i++;
        }
        for( $j=0; $j<$num;$j++ ){
            if(in_array($j,$anLo)){
                $k = array_search($j,$anLo);
                $newStr .= mb_substr($giveStr,$k*$bit,$bit); #echo $newStr."<br>";
            } else {
                $rd  = rand(0, intval((strlen($str)-1)/$bit));
                $wd  = mb_substr($str,$rd*$bit,$bit);
                $str = str_replace($wd, '', $str);
                $newStr .= $wd;
            }
        }
        return $newStr;
    }

}
