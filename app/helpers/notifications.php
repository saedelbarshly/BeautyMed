<?php
function notificationTextTranslate($parameters = [],$lang)
{
    $result = '';
    if (count($parameters) > 0) {
        if ($parameters['type'] == 'newPublisher') {
            $result = [
                'ar' => 'لقد قام '.$parameters['name'].' بالتسجيل في المنصة كناشر وبحاجة إلى المراجعة والموافقة.',
                'en' => 'Publisher with the name '.$parameters['name'].' has registered and needs your approval'
            ];
        }
        if ($parameters['type'] == 'activatePublisherAccount') {
            $result = [
                'ar' => 'لقد قام '.$parameters['name'].' وهو أحد المدراء بتفعيل حسابك بنجاح.',
                'en' => 'manager '.$parameters['name'].' has activated your account successfully'
            ];
        }
        if ($parameters['type'] == 'newPublisherMessage') {
            $result = [
                'ar' => 'لقد قام الناشر '.$parameters['name'].' بإرسال رسالة جديدة من خلال اتصل بنا.',
                'en' => 'publisher '.$parameters['name'].' has sent you anew contact message'
            ];
        }
        if ($parameters['type'] == 'newWriter') {
            $result = [
                'ar' => 'لقد قام الناشر '.$parameters['name'].' بإدخال بيانات كاتب جديد ويجب عليك مراجعته لتفعيله.',
                'en' => 'publisher '.$parameters['name'].' has add new writer and you have to review it te be published'
            ];
        }
    }
    return $result[$lang];
}

function notifyManagers($notificationType,$notificationData)
{
    if (in_array($notificationType, ['newPublisher','newPublisherMessage','newWriter'])) {
        $PrimeManagers = App\Models\User::where('role','1')->where('active','1')->get();
        foreach ($PrimeManagers as $key => $value) {
            $value->notify(new \App\Notifications\AdminNotifications($notificationData));
        }
    }
}

function notificationImageLink($type,$linked_id = '')
{
    $link = getSettingImageLink(getSettingValue('logo'));
    if ($type == 'newPublisher') {
        $thePublisher = App\Models\User::find($linked_id);
        if ($thePublisher != '') {
            $link = $thePublisher->photoLink();
        }
    }
    return $link;
}

function notifyPublisher($notificationData,$publisherId)
{
    $publisher = App\Models\User::find($publisherId);
    if ($publisher != '') {
        $publisher->notify(new \App\Notifications\PublisherNotifications($notificationData));
    }
}
