<?php

declare(strict_types = 1);

namespace App\Controller\Admin;

use App\Exception\Exception;
use App\Model\Upload\UploadFile;
use Psr\Http\Message\ResponseInterface;

class UploadFiles extends BaseController
{
    protected $model = UploadFile::class;

    /**
     * 单文件上传
     *
     * @param  string                        $file_name
     * @param  \App\Model\Upload\UploadFile  $uploadFile
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function file(string $file_name = 'file', UploadFile $uploadFile): ResponseInterface
    {
        // 存在则返回一个 Hyperf\HttpMessage\Upload\UploadedFile 对象，不存在则返回 null
        $file = $this->request->file($file_name);
        if (empty($file)) return $this->error('请上传文件！');

        try {
            // 获取文件扩展名
            $name = $uploadFile->getUniqidName($file->getExtension());
            // 图片的绝对路径
            $path = $uploadFile->getAbsolutePath($name);
            // 移动图片
            $file->moveTo($path);

            // 通过 isMoved(): bool 方法判断方法是否已移动
            if ( $file->isMoved() && $res = $uploadFile->addRecord($uploadFile->getFilePath($name), $file) ) {
                return $this->success($res);
            }
        } catch (Exception $e) {
            return $this->error('上传失败！');
        }
    }

    /**
     * 批量文件上传
     *
     * @param  string                        $file_name
     * @param  \App\Model\Upload\UploadFile  $uploadFile
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function files(string $file_name = 'files', UploadFile $uploadFile): ResponseInterface
    {
        $files = $this->request->file($file_name);
        if (empty($files)) return $this->error('请上传文件！');

        try{
            $list = [];
            foreach ($files as $file){
                // 获取文件扩展名
                $name = $uploadFile->getUniqidName($file->getExtension());
                // 图片的绝对路径
                $path = $uploadFile->getAbsolutePath($name);
                // 移动图片
                $file->moveTo($path);

                // 通过 isMoved(): bool 方法判断方法是否已移动
                if ( $file->isMoved() && $res = $uploadFile->addRecord($uploadFile->getFilePath($name), $file) ) {
                    $list[] = $res;
                }
            }
            return $this->success($list);
        }catch (Exception $e){
            return $this->error('上传失败！');
        }
    }
}
