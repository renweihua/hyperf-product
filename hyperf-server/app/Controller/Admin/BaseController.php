<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AbstractController;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Hyperf\Di\Annotation\Inject;
use Psr\Http\Message\ResponseInterface;

class BaseController extends AbstractController
{
    // 设定模型
    protected $model;
    protected $modelInstance;
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
        if ( !empty($this->model) ) {
            $this->modelInstance = $this->model::getInstance();
        }
    }

    protected function setSearchWhereFilter(&$model, array $params = []) : void
    {

    }

    /**
     * 列表数据
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index(): ResponseInterface
    {
        $model = $this->modelInstance::query();
        // 设置where条件
        if ( method_exists($this, 'setSearchWhereFilter') ) {
            $this->setSearchWhereFilter($model, $this->request->all());
        }
        $list = $this->modelInstance->getPaginate($model, $this->withModel, 10);
        return $this->success($list);
    }

    /**
     * 详情
     *
     * @param $id
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function detail($id): ResponseInterface
    {
        $detail = $this->modelInstance->with($this->detailWithModel)->find($id);
        return empty($detail) ? $this->error('获取失败') : $this->success($detail);
    }

    /**
     * 新增
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function create(): ResponseInterface
    {
        $params = $this->request->all();
        // 开启验证器
        if ( $this->validator ) {
            $validator = $this->validationFactory->make($params, $this->validator->getRules(__FUNCTION__), $this->validator->getMessages());
            if ( $validator->fails() ) {
                // Handle exception
                $errorMessage = $validator->errors()->first();
                return $this->error($errorMessage);
            }
        }

        if ( $this->modelInstance->add($params) ) {
            return $this->success([], '新增成功！');
        } else {
            return $this->error('新增失败！');
        }
    }

    /**
     * 更新数据
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    // , $id
    public function update(): ResponseInterface
    {
        $params = $this->request->all();
        // 开启验证器
        if ( $this->validator ) {
            $validator = $this->validationFactory->make($params, $this->validator->getRules(__FUNCTION__), $this->validator->getMessages());
            if ( $validator->fails() ) {
                // Handle exception
                $errorMessage = $validator->errors()->first();
                return $this->error($errorMessage);
            }
        }
        if ( $this->modelInstance->edit($params) ) {
            return $this->success([], '更新成功！');
        } else {
            return $this->error('更新失败！');
        }
    }

    /**
     * 批量删除
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function delete(): ResponseInterface
    {
        $params = $this->request->all();
        // 开启验证器
        if ( $this->validator ) {
            $validator = $this->validationFactory->make($params, $this->validator->getRules(__FUNCTION__), $this->validator->getMessages());
            if ( $validator->fails() ) {
                // Handle exception
                $errorMessage = $validator->errors()->first();
                return $this->error($errorMessage);
            }
        }
        if ( $this->modelInstance->batch_delete($params[$this->modelInstance->getKeyName()]) ) {
            return $this->success([], '删除成功！');
        } else {
            return $this->error('删除失败！');
        }
    }

    /**
     * 设置指定字段【常用于状态的变动】
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function changeFiledStatus(): ResponseInterface
    {
        $params = $this->request->all();
        // 开启验证器
        if ( $this->validator ) {
            $validator = $this->validationFactory->make($params, $this->validator->getRules(__FUNCTION__), $this->validator->getMessages());
            if ( $validator->fails() ) {
                // Handle exception
                $errorMessage = $validator->errors()->first();
                return $this->error($errorMessage);
            }
        }

        if ( $this->modelInstance->changeFiledStatus($params) ) {
            return $this->success([], $this->modelInstance->getError());
        } else {
            return $this->error($this->modelInstance->getError());
        }
    }

    /**
     * 下拉筛选列表（可搜索）
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getSelectLists(): ResponseInterface
    {
        $lists = $this->modelInstance->getSelectLists();
        return $this->success($lists);
    }
}
