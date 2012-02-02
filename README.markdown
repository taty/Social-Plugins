## Yii extension Social plugins that allows to add tweet, twitter connect, facebook buttons to your site
Yii ext Social plugins that allows to add tweet, twitter connect, facebook, googleplus buttons to your site  

### Installation ###

Extract the [Yii Social plugins][1] from archive under protected/extensions and rename this folder to the socialplugins
[1]: https://github.com/taty/Social-plugins        "Yii Social plugins"

## Usage and Configuration ##

For use [Yii Social plugins][1] need to add some code to configure to the component section:

``` php
<?php
//...
	'preload' => array('log','socialplugins'),
//...
	'socialplugins' => array(
            'class' => 'ext.socialplugins.TwitterConnect',
            'consumerKey' => 'YOUR_APP_CONSUMER_KEY',
            'consumerSecret' => 'YOUR_APP_CONSUMER_SECRET',
            'twitterRequestUrl' => 'https://api.twitter.com/oauth/request_token',
            'twitterAccessUrl' => 'https://api.twitter.com/oauth/access_token',
            'twitterAutorizeUrl' => 'https://api.twitter.com/oauth/authorize' 
        )
```
and you can add it in view section:

``` php
<?php 
//... 
	$this->widget('ext.socialplugins.SocialPlugins', array(
		'buttons'=>array(
                    "GooglePlusoneButton"=>array('id' => '1'),
                    "FacebookLikeButton"=>array('id' => '2'),
                    "TwitterConnectButton"=>array('id' => '3', 'template'=>'standart'),
                    "TweetButton"=>array(
                        'id' => '4','counturl'=>'http://YOUR_URL/',
                        'url' => 'http://YOUR_URL/',
                        'text' => 'My Share Information',
                        'username' => 'YOUR_USERNAME',
                        'count' => 'vertical',
                        'language' => 'en'
                    )
                ),
                'additionalButtons' => array(
                    'application.extensions.social-widgets.SampleButton'=>array('id'=>'5'),
                    'application.extensions.social-widgets.DiffButton'=>array('id'=>'6'),
                )
               
       	)
    );          
```
- you can sort these buttons by id
- you can add additional buttons if you need
- you can setting parametrs to each button
- if you using twitter connect you need to add callback url: http://YOUR_SITE/twconnect
now avalible template for twitterconnect:

- box
- standart

