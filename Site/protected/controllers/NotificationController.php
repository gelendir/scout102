<?php

class NotificationController extends AdminController
{

    public function actionIndex()
    {
        $notifications = Notification::model()->findAll();

        $this->render(
            'index',
            array(
                'action'=>'Notification/index',
                'notifications' => $notifications
            )
        );
    }

    public function actionRead($id)
    {
        $notificationRecu = Notification::model()->findByPk($id);

        $notificationRecu->LU = 1;
        $notificationRecu->save();

        $notifications = Notification::model()->findAll();
        $this->render(
            'index',
            array(
                'action'=>'Notification/index',
                'notifications' => $notifications
            )
        );

    }

}
