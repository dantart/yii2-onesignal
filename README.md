# yii2-onesignal
Yii2 component for OneSignal.com integration. Any contribution is highly encouraged!

This component is a [rocketfirm/yii2-onesignal](https://github.com/rocket-firm/yii2-onesignal) fork.

## Installation

Preferred way to install is through [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx).

```
composer require dantart/yii2-onesignal
```

## Configuration

Add following code to your configuration file (main.php):

```PHP
'components' => [
  // ...

  'onesignal' => [
    'appId' => 'ONESIGNAL_APP_ID',
    'apiKey' => 'ONESIGNAL_API_KEY',
  ]
]
```

## Usage

Run following command to send notifications:
```PHP
$message = [
  "headers" => [
    "en" => "Notification Example"
  ],
  "contents" => [
    "en" => "Click for more info"
  ]
];

$options = [
  "template_id" => "your-template-id",
  "url" => "https://github.com/dantart/yii2-onesignal"
];

$filterOne = ["field" => "tag", "key" => "your_tag_here", "relation" => "=", "value" => "your_tag_value_here"];
$filterOne = ["field" => "tag", "key" => "your_tag_here", "relation" => "=", "value" => "your_tag_value_here"];

$notification = \Yii::$app->onesignal->notifications()->create($message["headers"], $message["contents"], $options);
$notification->filter($filterOne);
$notification->operatorOr();
$notification->filter($filterTwo);

$notification->send();
```


### Other methods:

```PHP
// Notifications
\Yii::$app->onesignal->notifications()->getAll($params);
\Yii::$app->onesignal->notifications($id)->getOne();

//Players (device)
\Yii::$app->onesignal->players()->getAll($params);
\Yii::$app->onesignal->players($id)->getOne();
\Yii::$app->onesignal->players($id)->edit($params);
\Yii::$app->onesignal->players($id)->addTag($tagName, $tagValue);
\Yii::$app->onesignal->players($id)->addTag($tagsArray);
\Yii::$app->onesignal->players($id)->removeTag($tagName);

```

Visit official [onesignal.com documentation](https://documentation.onesignal.com/) for more details.
