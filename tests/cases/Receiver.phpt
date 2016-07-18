<?php

use Mangoweb\Messenger\Receiver;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$receiver = new Receiver();

$out = [];

$receiver->onRequest[]  = function($body) use (&$out) {
	$out[] = "onRequest";
};

$receiver->onEntry[]  = function($body) use (&$out) {
	$out[] = "onEntry";
};

$receiver->onReceive[]  = function($body) use (&$out) {
	$out[] = "onReceive";
};

$receiver->onMessage[]  = function($body) use (&$out) {
	$out[] = "onMessage";
};

$receiver->onPostback[]  = function($body) use (&$out) {
	$out[] = "onPostback";
};

$receiver->onOptin[]  = function($body) use (&$out) {
	$out[] = "onOptin";
};

$receiver->onAccountLinking[]  = function($body) use (&$out) {
	$out[] = "onAccountLinking";
};

$receiver->onDelivery[]  = function($body) use (&$out) {
	$out[] = "onDelivery";
};

$receiver->onRead[]  = function($body) use (&$out) {
	$out[] = "onRead";
};

$receiver->onEcho[]  = function($body) use (&$out) {
	$out[] = "onEcho";
};

$messageBody = '{
  "object":"page",
  "entry":[
    {
      "id":"PAGE_ID",
      "time":1458692752478,
      "messaging":[
{
  "sender":{
    "id":"USER_ID"
  },
  "recipient":{
    "id":"PAGE_ID"
  },
  "timestamp":1458692752478,
  "message":{
    "mid":"mid.1457764197618:41d102a3e1ae206a38",
    "seq":73,
    "text":"hello, world!",
    "quick_reply": {
      "payload": "DEVELOPER_DEFINED_PAYLOAD"
    }
  }
} 
      ]
    }
  ]
}';

$out = [];
$receiver->processBody(json_decode($messageBody, TRUE));
Assert::equal(['onRequest', 'onEntry', 'onReceive', 'onMessage'], $out);

$messageBody = '{
  "object":"page",
  "entry":[
    {
      "id":"PAGE_ID",
      "time":1458692752478,
      "messaging":[
{
  "sender":{
    "id":"USER_ID"
  },
  "recipient":{
    "id":"PAGE_ID"
  },
  "timestamp":1458692752478,
  "message":{
    "mid":"mid.1458696618141:b4ef9d19ec21086067",
    "seq":51,
    "attachments":[
      {
        "type":"image",
        "payload":{
          "url":"IMAGE_URL"
        }
      }
    ]
  }
}
      ]
    }
  ]
}';

$out = [];
$receiver->processBody(json_decode($messageBody, TRUE));
Assert::equal(['onRequest', 'onEntry', 'onReceive', 'onMessage'], $out);

$messageBody = '{
  "object":"page",
  "entry":[
    {
      "id":"PAGE_ID",
      "time":1458692752478,
      "messaging":[
{
  "sender":{
    "id":"USER_ID"
  },
  "recipient":{
    "id":"PAGE_ID"
  },
  "timestamp":1458692752478,
  "postback":{
    "payload":"USER_DEFINED_PAYLOAD"
  }
}
      ]
    }
  ]
}';

$out = [];
$receiver->processBody(json_decode($messageBody, TRUE));
Assert::equal(['onRequest', 'onEntry', 'onReceive', 'onPostback'], $out);

$messageBody = '{
  "object":"page",
  "entry":[
    {
      "id":"PAGE_ID",
      "time":1458692752478,
      "messaging":[
{
  "sender":{
    "id":"USER_ID"
  },
  "recipient":{
    "id":"PAGE_ID"
  },
  "timestamp":1234567890,
  "optin":{
    "ref":"PASS_THROUGH_PARAM"
  }
}
      ]
    }
  ]
}';

$out = [];
$receiver->processBody(json_decode($messageBody, TRUE));
Assert::equal(['onRequest', 'onEntry', 'onReceive', 'onOptin'], $out);

$messageBody = '{
  "object":"page",
  "entry":[
    {
      "id":"PAGE_ID",
      "time":1458692752478,
      "messaging":[
{
  "sender":{
    "id":"USER_ID"
  },
  "recipient":{
    "id":"PAGE_ID"
  },
  "timestamp":1234567890,
  "account_linking":{
    "status":"linked",
    "authorization_code":"PASS_THROUGH_AUTHORIZATION_CODE"
  }
}
      ]
    }
  ]
}';

$out = [];
$receiver->processBody(json_decode($messageBody, TRUE));
Assert::equal(['onRequest', 'onEntry', 'onReceive', 'onAccountLinking'], $out);

$messageBody = '{
  "object":"page",
  "entry":[
    {
      "id":"PAGE_ID",
      "time":1458692752478,
      "messaging":[
{
  "sender":{
    "id":"USER_ID"
  },
  "recipient":{
    "id":"PAGE_ID"
  },
  "timestamp":1234567890,
  "account_linking":{
    "status":"unlinked"
  }
}
      ]
    }
  ]
}';

$out = [];
$receiver->processBody(json_decode($messageBody, TRUE));
Assert::equal(['onRequest', 'onEntry', 'onReceive', 'onAccountLinking'], $out);

$messageBody = '{
  "object":"page",
  "entry":[
    {
      "id":"PAGE_ID",
      "time":1458692752478,
      "messaging":[
{
   "sender":{
      "id":"USER_ID"
   },
   "recipient":{
      "id":"PAGE_ID"
   },
   "delivery":{
      "mids":[
         "mid.1458668856218:ed81099e15d3f4f233"
      ],
      "watermark":1458668856253,
      "seq":37
   }
}
      ]
    }
  ]
}';

$out = [];
$receiver->processBody(json_decode($messageBody, TRUE));
Assert::equal(['onRequest', 'onEntry', 'onReceive', 'onDelivery'], $out);

$messageBody = '{
  "object":"page",
  "entry":[
    {
      "id":"PAGE_ID",
      "time":1458692752478,
      "messaging":[
{
   "sender":{
      "id":"USER_ID"
   },
   "recipient":{
      "id":"PAGE_ID"
   },
   "timestamp":1458668856463,
   "read":{
      "watermark":1458668856253,
      "seq":38
   }
}
      ]
    }
  ]
}';

$out = [];
$receiver->processBody(json_decode($messageBody, TRUE));
Assert::equal(['onRequest', 'onEntry', 'onReceive', 'onRead'], $out);

$messageBody = '{
  "object":"page",
  "entry":[
    {
      "id":"PAGE_ID",
      "time":1458692752478,
      "messaging":[
{
  "sender":{
    "id":"PAGE_ID"
  },
  "recipient":{
    "id":"USER_ID"
  },
  "timestamp":1457764197627,
  "message":{
    "is_echo":true,
    "app_id":1517776481860111,
    "metadata": "DEVELOPER_DEFINED_METADATA_STRING",
    "mid":"mid.1457764197618:41d102a3e1ae206a38",
    "seq":73
  }
}
      ]
    }
  ]
}';

$out = [];
$receiver->processBody(json_decode($messageBody, TRUE));
Assert::equal(['onRequest', 'onEntry', 'onReceive', 'onEcho'], $out);

$messageBody = '{
  "object":"invalid-message"
}';

$out = [];
Assert::exception(function() use ($receiver, $messageBody) {
	$receiver->processBody(json_decode($messageBody, TRUE));
}, 'Mangoweb\Messenger\InvalidBodyException', 'Messenger Receiver cannot process this body.');
