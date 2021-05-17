<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

/**
 * Инициализатор RBAC выполняется в консоли php yii rbac/init
 */
class RbacController extends Controller {

    public function actionInit() {
        $auth = Yii::$app->authManager;

        $auth->removeAll();

        //создание ролей
        $admin = $auth->createRole('admin');
        $user = $auth->createRole('user');

        $auth->add($admin);
        $auth->add($user);

        //Создание разрешений
        $viewChat = $auth->createPermission('viewChat');
        $viewChat->description = 'Просмотр сообщений';

        $sendMessage = $auth->createPermission('sendMessage');
        $sendMessage->description = 'Отправка сообщений';

        $viewAdminPage = $auth->createPermission('viewAdminPage');
        $viewAdminPage->description = 'Просмотр админки';

        $manageUsers = $auth->createPermission('manageUsers');
        $manageUsers->description = 'Просмотр пользователей';

        $manageRoles = $auth->createPermission('manageRoles');
        $manageRoles->description = 'Управление ролями';

        $viewBannedMessages = $auth->createPermission('viewBannedMessages');
        $viewBannedMessages->description = 'Просмотр списка запрещеных сообщений';

        $banMessage = $auth->createPermission('banMessage');
        $banMessage->description = 'Скрыть сообщение из чата';

        $allowMessage = $auth->createPermission('allowMessage');
        $allowMessage->description = 'Возврат сообщения в чат';

        $auth->add($viewChat);
        $auth->add($sendMessage);
        $auth->add($viewAdminPage);
        $auth->add($manageUsers);
        $auth->add($manageRoles);
        $auth->add($viewBannedMessages);
        $auth->add($banMessage);
        $auth->add($allowMessage);


        //Привязываем разрешение к роли
        $auth->addChild($user, $viewChat);
        $auth->addChild($user, $sendMessage);

        $auth->addChild($admin, $user);
        $auth->addChild($admin, $viewAdminPage);
        $auth->addChild($admin, $manageUsers);
        $auth->addChild($admin, $manageRoles);
        $auth->addChild($admin, $viewBannedMessages);
        $auth->addChild($admin, $banMessage);
        $auth->addChild($admin, $allowMessage);

        //Привязываем роль пользователю
        $auth->assign($admin, 1);

        $auth->assign($user, 2);
    }
}