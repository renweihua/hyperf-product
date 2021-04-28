<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AbstractController;
use App\Exception\Exception;
use App\Model\Rabc\AdminMenu;
use App\Request\Admin\LoginRequest;
use App\Service\Admin\LoginService;
use Hyperf\Di\Annotation\Inject;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Login
 *
 * @package App\Controller\Admin
 */
class Login extends AbstractController
{
    /**
     * @Inject()
     * @var LoginService
     */
    private $loginService;

    public function login(LoginRequest $request): ResponseInterface
    {
        // 获取通过验证的数据...
        $data = $request->validated();

        try {
            $data = $this->loginService->login($data['admin_name'], $data['password']);

            return $this->success($data);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function me()
    {
        if($res = $this->loginService->me($this->request->getAttribute('admin_id'))){
            return $this->success($res, $this->loginService->getError());
        }else{
            return $this->error($this->loginService->getError());
        }
    }

    public function getRabcList(){
        return $this->success(list_to_tree(AdminMenu::getAllMenus()->toArray()));
    }
}
