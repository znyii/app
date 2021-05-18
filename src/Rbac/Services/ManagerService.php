<?php

namespace ZnYii\App\Rbac\Services;

use ZnBundle\Rbac\Domain\Enums\RbacRoleEnum;
use ZnBundle\Rbac\Domain\Interfaces\CheckAccessInterface;
use ZnBundle\User\Domain\Interfaces\Services\AuthServiceInterface;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnSandbox\Sandbox\Casbin\Domain\Interfaces\Repositories\AssignmentRepositoryInterface;
use ZnSandbox\Sandbox\Casbin\Domain\Interfaces\Services\ManagerServiceInterface;

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
        $assignmentCollection = $this->assignmentRepository->allByIdentityId($userId);
        $roles = EntityHelper::getColumn($assignmentCollection, 'itemName');
        return $this->casbinService->isCanByRoleNames($roles, [$permissionName]);
    }
}
