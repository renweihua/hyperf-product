<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AbstractController;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Hyperf\Di\Annotation\Inject;

class BaseController extends AbstractController
{
    // 设定模型
    protected $model;
    protected $model_class;
    // 验证器
    protected $validator;
    // 关联模型设定
    protected $withModel = [],//关联模型
        $detailWithModel = [];//详情的模型

    /**
     * @Inject()
     * @var ValidatorFactoryInterface
     */
    protected $validationFactory;

    public function __construct()
    {
        if ( !empty($this->model_class) ) {
            $this->model = $this->model_class::getInstance();
        }

        // 验证器实例化
        if ( $this->validator ) $this->validator = $this->validator::getInstance();
    }

    protected function setSearchWhereFilter(&$model, array $params = []) : void
    {

    }

    /**
     * 列表数据
     *
     * @param  \Hyperf\HttpServer\Contract\RequestInterface  $request
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index(RequestInterface $request)
    {
        $model = $this->model::query();
        // 设置where条件
        if ( method_exists($this, 'setSearchWhereFilter') ) {
            $this->setSearchWhereFilter($model, $request->all());
        }
        $list = $this->model->getPaginate($model, $this->withModel, 10);
        return $this->success($list);
    }

    public function detail($id)
    {
        $detail = $this->model->with($this->detailWithModel)->find($id);
        return empty($detail) ? $this->error('获取失败') : $this->success($detail);
    }

    /**
     * 新增
     *
     * @param  \Hyperf\HttpServer\Contract\RequestInterface  $request
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function create(RequestInterface $request)
    {
        $params = $request->all();
        // 开启验证器
        if ( $this->validator ) {
            $validator = $this->validationFactory->make($params, $this->validator->getRules(__FUNCTION__), $this->validator->getMessages());
            if ( $validator->fails() ) {
                // Handle exception
                $errorMessage = $validator->errors()->first();
                return $this->error($errorMessage);
            }
        }

        if ( $this->model->add($params) ) {
            return $this->success();
        } else {
            return $this->error('新增失败');
        }
    }

    /**
     * 更新数据
     *
     * @param  \Hyperf\HttpServer\Contract\RequestInterface  $request
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    // , $id
    public function update(RequestInterface $request)
    {
        $params = $request->all();
        // 开启验证器
        if ( $this->validator ) {
            $validator = $this->validationFactory->make($params, $this->validator->getRules(__FUNCTION__), $this->validator->getMessages());
            if ( $validator->fails() ) {
                // Handle exception
                $errorMessage = $validator->errors()->first();
                return $this->error($errorMessage);
            }
        }
        if ( $this->model->edit($params) ) {
            return $this->success();
        } else {
            return $this->error('更新失败');
        }
    }

    /**
     * 批量删除
     *
     * @param  \Hyperf\HttpServer\Contract\RequestInterface  $request
     * @param                                                $id
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function delete(RequestInterface $request)
    {
        $params = $request->all();
        // 开启验证器
        if ( $this->validator ) {
            $validator = $this->validationFactory->make($request->all(), $this->validator->getRules(__FUNCTION__), $this->validator->getMessages());
            if ( $validator->fails() ) {
                // Handle exception
                $errorMessage = $validator->errors()->first();
                return $this->error($errorMessage);
            }
        }
        if ( $this->model->batch_delete($params[$this->model->getKeyName()]) ) {
            return $this->success();
        } else {
            return $this->error();
        }
    }

    /**
     * 设置指定字段【常用于状态的变动】
     *
     * @param  \Hyperf\HttpServer\Contract\RequestInterface  $request
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function changeFiledStatus(RequestInterface $request)
    {
        $params = $request->all();
        // 开启验证器
        if ( $this->validator ) {
            $validator = $this->validationFactory->make($request->all(), $this->validator->getRules(__FUNCTION__), $this->validator->getMessages());
            if ( $validator->fails() ) {
                // Handle exception
                $errorMessage = $validator->errors()->first();
                return $this->error($errorMessage);
            }
        }

        if ( $this->model->changeFiledStatus($params) ) {
            return $this->success([], $this->model->getError());
        } else {
            return $this->error($this->model->getError());
        }
    }
}