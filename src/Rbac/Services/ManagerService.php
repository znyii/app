<?php

namespace ZnYii\App\Rbac\Services;

use ZnBundle\User\Domain\Interfaces\Services\AuthServiceInterface;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnUser\Rbac\Domain\Enums\RbacRoleEnum;
use ZnUser\Rbac\Domain\Interfaces\CheckAccessInterface;
use ZnUser\Rbac\Domain\Interfaces\Services\AssignmentServiceInterface;
use ZnUser\Rbac\Domain\Interfaces\Services\ManagerServiceInterface;

class ManagerService implements CheckAccessInterface
{

    private $authService;
    private $casbinService;
    private $assignmentService;

    public function __construct(
        AssignmentServiceInterface $assignmentService,
        ManagerServiceInterface $casbinService,
        AuthServiceInterface $authService
    )
    {
        $this->assignmentService = $assignmentService;
        $this->authService = $authService;
        $this->casbinService = $casbinService;
    }

    public function checkAccess(?int $userId, string $permissionName, array $params = [])
    {
        if ($permissionName == RbacRoleEnum::GUEST) {
            return true;
        }
        if ($permissionName == RbacRoleEnum::AUTHORIZED && !empty($userId)) {
            return true;
        }
        if($userId) {
            $roles = $this->assignmentService->getRolesByIdentityId($userId);
        } else {
            $roles = $this->casbinService->getDefaultRoles();
        }
        return $this->casbinService->isCanByRoleNames($roles, [$permissionName]);
    }
}
