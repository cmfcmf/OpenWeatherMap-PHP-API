"use strict";(self.webpackChunkdocs=self.webpackChunkdocs||[]).push([[827],{4137:function(e,t,n){n.d(t,{Zo:function(){return s},kt:function(){return d}});var a=n(7294);function r(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}function o(e,t){var n=Object.keys(e);if(Object.getOwnPropertySymbols){var a=Object.getOwnPropertySymbols(e);t&&(a=a.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),n.push.apply(n,a)}return n}function p(e){for(var t=1;t<arguments.length;t++){var n=null!=arguments[t]?arguments[t]:{};t%2?o(Object(n),!0).forEach((function(t){r(e,t,n[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(n)):o(Object(n)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(n,t))}))}return e}function c(e,t){if(null==e)return{};var n,a,r=function(e,t){if(null==e)return{};var n,a,r={},o=Object.keys(e);for(a=0;a<o.length;a++)n=o[a],t.indexOf(n)>=0||(r[n]=e[n]);return r}(e,t);if(Object.getOwnPropertySymbols){var o=Object.getOwnPropertySymbols(e);for(a=0;a<o.length;a++)n=o[a],t.indexOf(n)>=0||Object.prototype.propertyIsEnumerable.call(e,n)&&(r[n]=e[n])}return r}var i=a.createContext({}),l=function(e){var t=a.useContext(i),n=t;return e&&(n="function"==typeof e?e(t):p(p({},t),e)),n},s=function(e){var t=l(e.components);return a.createElement(i.Provider,{value:t},e.children)},u="mdxType",h={inlineCode:"code",wrapper:function(e){var t=e.children;return a.createElement(a.Fragment,{},t)}},m=a.forwardRef((function(e,t){var n=e.components,r=e.mdxType,o=e.originalType,i=e.parentName,s=c(e,["components","mdxType","originalType","parentName"]),u=l(n),m=r,d=u["".concat(i,".").concat(m)]||u[m]||h[m]||o;return n?a.createElement(d,p(p({ref:t},s),{},{components:n})):a.createElement(d,p({ref:t},s))}));function d(e,t){var n=arguments,r=t&&t.mdxType;if("string"==typeof e||r){var o=n.length,p=new Array(o);p[0]=m;var c={};for(var i in t)hasOwnProperty.call(t,i)&&(c[i]=t[i]);c.originalType=e,c[u]="string"==typeof e?e:r,p[1]=c;for(var l=2;l<o;l++)p[l]=n[l];return a.createElement.apply(null,p)}return a.createElement.apply(null,n)}m.displayName="MDXCreateElement"},1639:function(e,t,n){n.r(t),n.d(t,{assets:function(){return s},contentTitle:function(){return i},default:function(){return d},frontMatter:function(){return c},metadata:function(){return l},toc:function(){return u}});var a=n(7462),r=n(3366),o=(n(7294),n(4137)),p=["components"],c={title:"Usage"},i=void 0,l={unversionedId:"usage",id:"usage",title:"Usage",description:"All APIs can be accessed through the Cmfcmf\\OpenWeatherMap object.",source:"@site/docs/usage.md",sourceDirName:".",slug:"/usage",permalink:"/OpenWeatherMap-PHP-API/docs/usage",draft:!1,editUrl:"https://github.com/cmfcmf/OpenWeatherMap-PHP-API/edit/master/docs/docs/usage.md",tags:[],version:"current",lastUpdatedBy:"\u24d6 \u24df \u24d1",lastUpdatedAt:1720850643,formattedLastUpdatedAt:"Jul 13, 2024",frontMatter:{title:"Usage"},sidebar:"someSidebar",previous:{title:"API Key",permalink:"/OpenWeatherMap-PHP-API/docs/api-key"},next:{title:"Current Weather",permalink:"/OpenWeatherMap-PHP-API/docs/apis/current-weather"}},s={},u=[{value:"Example",id:"example",level:2},{value:"<code>Unit</code> objects",id:"unit-objects",level:2},{value:"Caching requests",id:"caching-requests",level:2},{value:"Exception handling",id:"exception-handling",level:2}],h={toc:u},m="wrapper";function d(e){var t=e.components,n=(0,r.Z)(e,p);return(0,o.kt)(m,(0,a.Z)({},h,n,{components:t,mdxType:"MDXLayout"}),(0,o.kt)("p",null,"All APIs can be accessed through the ",(0,o.kt)("inlineCode",{parentName:"p"},"Cmfcmf\\OpenWeatherMap")," object.\nTo construct this object, you need to supply your API key, the PSR-18-compatible\nHTTP client and the PSR-17-compatible HTTP request factory:"),(0,o.kt)("pre",null,(0,o.kt)("code",{parentName:"pre",className:"language-php"},"use Cmfcmf\\OpenWeatherMap;\n\n$owm = new OpenWeatherMap('YOUR-API-KEY', $httpClient, $httpRequestFactory);\n")),(0,o.kt)("blockquote",null,(0,o.kt)("p",{parentName:"blockquote"},(0,o.kt)("strong",{parentName:"p"},"Note:")," From now on, we will refer to the instance of ",(0,o.kt)("inlineCode",{parentName:"p"},"Cmfcmf\\OpenWeatherMap")," as ",(0,o.kt)("inlineCode",{parentName:"p"},"$owm"),".")),(0,o.kt)("h2",{id:"example"},"Example"),(0,o.kt)("pre",null,(0,o.kt)("code",{parentName:"pre",className:"language-php"},"<?php\nuse Cmfcmf\\OpenWeatherMap;\nuse Cmfcmf\\OpenWeatherMap\\Exception as OWMException;\nuse Http\\Factory\\Guzzle\\RequestFactory;\nuse Http\\Adapter\\Guzzle6\\Client as GuzzleAdapter;\n\n// If you are not using a PHP framework that has included Composer's autoloader for you,\n// you'll need to `require` the autoloader script before working with this API:\nrequire 'vendor/autoload.php';\n\n// If you installed the recommended PSR-17/18 implementations, here's how to create the\n// necessary `$httpClient` and `$httpRequestFactory`:\n$httpRequestFactory = new RequestFactory();\n$httpClient = GuzzleAdapter::createWithConfig([]);\n\n$owm = new OpenWeatherMap('YOUR-API-KEY', $httpClient, $httpRequestFactory);\n\ntry {\n    $weather = $owm->getWeather('Berlin', 'metric', 'de');\n} catch(OWMException $e) {\n    echo 'OpenWeatherMap exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';\n} catch(\\Exception $e) {\n    echo 'General exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';\n}\n\necho $weather->temperature;\n")),(0,o.kt)("h2",{id:"unit-objects"},(0,o.kt)("inlineCode",{parentName:"h2"},"Unit")," objects"),(0,o.kt)("p",null,"Most values like temperature, precipitation, etc., are returned as instances of the\n",(0,o.kt)("inlineCode",{parentName:"p"},"Cmfcmf\\OpenWeatherMap\\Util\\Unit")," class. These objects provide you with\nthe value (e.g., ",(0,o.kt)("inlineCode",{parentName:"p"},"26.9"),"),\nthe unit (e.g., ",(0,o.kt)("inlineCode",{parentName:"p"},"\xb0C"),"),\nand sometimes a description (e.g., ",(0,o.kt)("inlineCode",{parentName:"p"},"heavy rain"),").\nTo make this clearer, let's look at a concrete example:"),(0,o.kt)("pre",null,(0,o.kt)("code",{parentName:"pre",className:"language-php"},'$weather = $owm->getWeather(\'Berlin\', \'metric\');\n// @var Cmfcmf\\OpenWeatherMap\\Util\\Unit $temperature\n$temperature = $weather->temperature->now;\n\n$temperature->getValue(); // 26.9\n$temperature->getUnit(); // "\xb0C"\n$temperature->getDescription(); // ""\n$temperature->getFormatted(); // "26.9 \xb0C"\n$temperature->__toString(); // "26.9 \xb0C"\n')),(0,o.kt)("h2",{id:"caching-requests"},"Caching requests"),(0,o.kt)("p",null,"You can automatically cache requests by supplying a ",(0,o.kt)("a",{parentName:"p",href:"https://www.php-fig.org/psr/psr-6/"},"PSR-6-compatible"),"\ncache as the fourth constructor parameter and the time to live as the fifth parameter:"),(0,o.kt)("pre",null,(0,o.kt)("code",{parentName:"pre",className:"language-php",metastring:"{7}","{7}":!0},"use Cmfcmf\\OpenWeatherMap;\n\n// Cache time in seconds, defaults to 600 = 10 minutes.\n$ttl = 600;\n\n$owm = new OpenWeatherMap('YOUR-API-KEY', $httpClient, $httpRequestFactory,\n                          $cache, $ttl);\n")),(0,o.kt)("p",null,"You can check whether the last request was cached by calling ",(0,o.kt)("inlineCode",{parentName:"p"},"->wasCached()"),":"),(0,o.kt)("pre",null,(0,o.kt)("code",{parentName:"pre",className:"language-php",metastring:"{3}","{3}":!0},'$owm->getRawWeatherData(\'Berlin\');\n\nif ($owm->wasCached()) {\n  echo "last request was cached";\n} else {\n  echo "last request was not cached";\n}\n')),(0,o.kt)("h2",{id:"exception-handling"},"Exception handling"),(0,o.kt)("p",null,"Make sure to handle exceptions appropriately.\nWhenever the OpenWeatherMap API returns an exception, it is converted into an instance of\n",(0,o.kt)("inlineCode",{parentName:"p"},"Cmfcmf\\OpenWeatherMap\\Exception"),".\nAs a special case, the API will throw a ",(0,o.kt)("inlineCode",{parentName:"p"},"Cmfcmf\\OpenWeatherMap\\NotFoundException")," if the city/location/coordinates you are querying cannot be found. This exception inherits from ",(0,o.kt)("inlineCode",{parentName:"p"},"Cmfcmf\\OpenWeatherMap\\Exception"),"."),(0,o.kt)("p",null,"If anything else goes wrong, an exception inheriting from ",(0,o.kt)("inlineCode",{parentName:"p"},"\\Exception")," is thrown."),(0,o.kt)("pre",null,(0,o.kt)("code",{parentName:"pre",className:"language-php",metastring:"{5,7}","{5,7}":!0},"use Cmfcmf\\OpenWeatherMap\\Exception as OWMException;\nuse Cmfcmf\\OpenWeatherMap\\NotFoundException as OWMNotFoundException;\n\ntry {\n    $weather = $owm->getWeather('Berlin');\n} catch (OWMNotFoundException $e) {\n    // TODO: Handle \"city was not found\" exception\n    // You can opt to skip the handler for `OWMNotFoundException`, because it extends `OWMException`.\n} catch (OWMException $e) {\n    // TODO: Handle API exception\n} catch (\\Exception $e) {\n    // TODO: Handle general exception\n}\n")))}d.isMDXComponent=!0}}]);