<?php

declare(strict_types = 1);

namespace App\Controller\Admin;

use App\Exception\Exception;
use App\Model\Upload\UploadFile;

class UploadFiles extends BaseController
{
    protected $model = UploadFile::class;

    /**
     * 单图上传
     *
     * @param  string                        $file_name
     * @param  \App\Model\Upload\UploadFile  $uploadFile
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function file($file_name = 'file', UploadFile $uploadFile)
    {
        // 存在则返回一个 Hyperf\HttpMessage\Upload\UploadedFile 对象，不存在则返回 null
        $file = $this->request->file($file_name);
        if (empty($file)) return $this->error('请上传文件');

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
            return $this->error('上传失败');
        }
    }

    public function files($file_name = 'file', UploadFile $uploadFile)
    {

    }
}
