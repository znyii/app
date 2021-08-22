<?php

namespace ZnYii\App\Rbac\Services;

use ZnBundle\User\Domain\Interfaces\Services\AuthServiceInterface;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnUser\Rbac\Domain\Enums\RbacRoleEnum;
use ZnUser\Rbac\Domain\Interfaces\CheckAccessInterface;
use ZnUser\Rbac\Domain\Interfaces\Repositories\AssignmentRepositoryInterface;
use ZnUser\Rbac\Domain\Interfaces\Services\ManagerServiceInterface;

class ManagerService implements CheckAccessInterface
{

    private $assignmentRepository;
    private $authService;
    private $casbinService;

    public function __construct(
        AssignmentRepositoryInterface $assignmentRepository,
        ManagerServiceInterface $casbinService,
        AuthServiceInterface $authService
    )
    {
        $this->assignmentRepository = $assignmentRepository;
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
            $assignmentCollection = $this->assignmentRepository->allByIdentityId($userId);
            $roles = EntityHelper::getColumn($assignmentCollection, 'itemName');
        } else {
            $roles = $this->casbinService->getDefaultRoles();
        }
        return $this->casbinService->isCanByRoleNames($roles, [$permissionName]);
    }
}
