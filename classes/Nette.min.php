<?php //netteloader=Nette\Framework

namespace {/**
 * Nette Framework (version 2.1-dev released on 2013-07-11, http://nette.org)
 *
 * Copyright (c) 2004, 2013 David Grudl (http://davidgrudl.com)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

if(PHP_VERSION_ID<50301){throw
new
Exception('Nette Framework requires PHP 5.3.1 or newer.');}@header('Content-Type: text/html; charset=utf-8');define('NETTE',TRUE);define('NETTE_DIR',__DIR__);define('NETTE_VERSION_ID',20100);}namespace Nette\Diagnostics{use
Nette;interface
IBarPanel{function
getTab();function
getPanel();}}namespace Nette\Application{use
Nette;interface
IPresenter{function
run(Request$request);}interface
IPresenterFactory{function
getPresenterClass(&$name);function
createPresenter($name);}interface
IResponse{function
send(Nette\Http\IRequest$httpRequest,Nette\Http\IResponse$httpResponse);}interface
IRouter{const
ONE_WAY=1;const
SECURED=2;function
match(Nette\Http\IRequest$httpRequest);function
constructUrl(Request$appRequest,Nette\Http\Url$refUrl);}}namespace Nette\ComponentModel{use
Nette;interface
IComponent{const
NAME_SEPARATOR='-';function
getName();function
getParent();function
setParent(IContainer$parent=NULL,$name=NULL);}interface
IContainer
extends
IComponent{function
addComponent(IComponent$component,$name);function
removeComponent(IComponent$component);function
getComponent($name);function
getComponents($deep=FALSE,$filterType=NULL);}}namespace Nette\Application\UI{use
Nette;interface
ISignalReceiver{function
signalReceived($signal);}interface
IStatePersistent{function
loadState(array$params);function
saveState(array&$params);}interface
IRenderable{function
invalidateControl();function
isControlInvalid();}}namespace Nette\Caching{use
Nette;interface
IStorage{function
read($key);function
lock($key);function
write($key,$data,array$dependencies);function
remove($key);function
clean(array$conditions);}}namespace Nette\Caching\Storages{use
Nette;interface
IJournal{function
write($key,array$dependencies);function
clean(array$conditions);}}namespace Nette{use
Nette;interface
IFreezable{function
freeze();function
isFrozen();}}namespace Nette\Database{use
Nette;interface
ISupplementalDriver{const
SUPPORT_SEQUENCE='sequence',SUPPORT_SELECT_UNGROUPED_COLUMNS='ungrouped_cols',SUPPORT_MULTI_INSERT_AS_SELECT='insert_as_select',SUPPORT_MULTI_COLUMN_AS_OR_COND='multi_column_as_or',SUPPORT_SUBSELECT='subselect';function
delimite($name);function
formatBool($value);function
formatDateTime(\DateTime$value);function
formatLike($value,$pos);function
applyLimit(&$sql,$limit,$offset);function
normalizeRow($row);function
getTables();function
getColumns($table);function
getIndexes($table);function
getForeignKeys($table);function
getColumnTypes(\PDOStatement$statement);function
isSupported($item);}interface
IReflection{const
FIELD_TEXT='string',FIELD_BINARY='bin',FIELD_BOOL='bool',FIELD_INTEGER='int',FIELD_FLOAT='float',FIELD_DATE='date',FIELD_TIME='time',FIELD_DATETIME='datetime',FIELD_UNIX_TIMESTAMP='timestamp';function
getPrimary($table);function
getHasManyReference($table,$key);function
getBelongsToReference($table,$key);}interface
IRow
extends\Traversable,\ArrayAccess{}interface
IRowContainer
extends\Traversable{function
fetch();function
fetchPairs($key,$value=NULL);function
fetchAll();}}namespace Nette\Database\Table{use
Nette\Database;interface
IRow
extends
Database\IRow{function
setTable(Selection$name);function
getTable();function
getPrimary($need=TRUE);function
getSignature($need=TRUE);function
related($key,$throughColumn=NULL);function
ref($key,$throughColumn=NULL);}/**
 * Container of database result fetched into IRow objects.
 *
 * @author     Jan Skrasek
 *
 * @method     IRow|bool  fetch() Fetches single row object.
 * @method     IRow[]     fetchAll() Fetches all rows.
 */interface
IRowContainer
extends
Database\IRowContainer{}}namespace Nette\DI\Config{use
Nette;interface
IAdapter{function
load($file);function
dump(array$data);}}namespace Nette\Forms{use
Nette;interface
IControl{function
setValue($value);function
getValue();function
validate();function
getErrors();function
isOmitted();function
translate($s,$count=NULL);}interface
ISubmitterControl
extends
IControl{function
getValidationScope();}interface
IFormRenderer{function
render(Form$form);}}namespace Nette\Http{use
Nette;interface
IRequest{const
GET='GET',POST='POST',HEAD='HEAD',PUT='PUT',DELETE='DELETE';function
getUrl();function
getQuery($key=NULL,$default=NULL);function
getPost($key=NULL,$default=NULL);function
getFile($key);function
getFiles();function
getCookie($key,$default=NULL);function
getCookies();function
getMethod();function
isMethod($method);function
getHeader($header,$default=NULL);function
getHeaders();function
isSecured();function
isAjax();function
getRemoteAddress();function
getRemoteHost();}interface
IResponse{const
PERMANENT=2116333333;const
BROWSER=0;const
S200_OK=200,S204_NO_CONTENT=204,S300_MULTIPLE_CHOICES=300,S301_MOVED_PERMANENTLY=301,S302_FOUND=302,S303_SEE_OTHER=303,S303_POST_GET=303,S304_NOT_MODIFIED=304,S307_TEMPORARY_REDIRECT=307,S400_BAD_REQUEST=400,S401_UNAUTHORIZED=401,S403_FORBIDDEN=403,S404_NOT_FOUND=404,S405_METHOD_NOT_ALLOWED=405,S410_GONE=410,S500_INTERNAL_SERVER_ERROR=500,S501_NOT_IMPLEMENTED=501,S503_SERVICE_UNAVAILABLE=503;function
setCode($code);function
getCode();function
setHeader($name,$value);function
addHeader($name,$value);function
setContentType($type,$charset=NULL);function
redirect($url,$code=self::S302_FOUND);function
setExpiration($seconds);function
isSent();function
getHeaders();function
setCookie($name,$value,$expire,$path=NULL,$domain=NULL,$secure=NULL,$httpOnly=NULL);function
deleteCookie($name,$path=NULL,$domain=NULL,$secure=NULL);}interface
ISessionStorage{function
open($savePath,$sessionName);function
close();function
read($id);function
write($id,$data);function
remove($id);function
clean($maxlifetime);}}namespace Nette\Security{use
Nette;interface
IUserStorage{const
MANUAL=1,INACTIVITY=2,BROWSER_CLOSED=4;const
CLEAR_IDENTITY=8;function
setAuthenticated($state);function
isAuthenticated();function
setIdentity(IIdentity$identity=NULL);function
getIdentity();function
setExpiration($time,$flags=0);function
getLogoutReason();}}namespace Nette\Latte{use
Nette;interface
IMacro{function
initialize();function
finalize();function
nodeOpened(MacroNode$node);function
nodeClosed(MacroNode$node);}}namespace Nette\Localization{use
Nette;interface
ITranslator{function
translate($message,$count=NULL);}}namespace Nette\Mail{use
Nette;interface
IMailer{function
send(Message$mail);}}namespace Nette\Reflection{use
Nette;interface
IAnnotation{function
__construct(array$values);}}namespace Nette\Security{use
Nette;interface
IAuthenticator{const
USERNAME=0,PASSWORD=1;const
IDENTITY_NOT_FOUND=1,INVALID_CREDENTIAL=2,FAILURE=3,NOT_APPROVED=4;function
authenticate(array$credentials);}interface
IAuthorizator{const
ALL=NULL;const
ALLOW=TRUE;const
DENY=FALSE;function
isAllowed($role,$resource,$privilege);}interface
IIdentity{function
getId();function
getRoles();}interface
IResource{function
getResourceId();}interface
IRole{function
getRoleId();}}namespace Nette\Templating{use
Nette;interface
ITemplate{function
render();}interface
IFileTemplate
extends
ITemplate{function
setFile($file);function
getFile();}}namespace Nette{use
Nette;class
ArgumentOutOfRangeException
extends\InvalidArgumentException{}class
InvalidStateException
extends\RuntimeException{}class
NotImplementedException
extends\LogicException{}class
NotSupportedException
extends\LogicException{}class
DeprecatedException
extends
NotSupportedException{}class
MemberAccessException
extends\LogicException{}class
IOException
extends\RuntimeException{}class
FileNotFoundException
extends
IOException{}class
DirectoryNotFoundException
extends
IOException{}class
InvalidArgumentException
extends\InvalidArgumentException{}class
OutOfRangeException
extends\OutOfRangeException{}class
UnexpectedValueException
extends\UnexpectedValueException{}class
StaticClassException
extends\LogicException{}class
FatalErrorException
extends\ErrorException{function
__construct($message,$code,$severity,$file,$line,$context,\Exception$previous=NULL){parent::__construct($message,$code,$severity,$file,$line,$previous);$this->context=$context;}}abstract
class
Object{static
function
getReflection(){return
new
Reflection\ClassType(get_called_class());}function
__call($name,$args){return
ObjectMixin::call($this,$name,$args);}static
function
__callStatic($name,$args){return
ObjectMixin::callStatic(get_called_class(),$name,$args);}static
function
extensionMethod($name,$callback=NULL){if(strpos($name,'::')===FALSE){$class=get_called_class();}else{list($class,$name)=explode('::',$name);$rc=new\ReflectionClass($class);$class=$rc->getName();}if($callback===NULL){return
ObjectMixin::getExtensionMethod($class,$name);}else{ObjectMixin::setExtensionMethod($class,$name,$callback);}}function&__get($name){return
ObjectMixin::get($this,$name);}function
__set($name,$value){return
ObjectMixin::set($this,$name,$value);}function
__isset($name){return
ObjectMixin::has($this,$name);}function
__unset($name){ObjectMixin::remove($this,$name);}}}namespace Nette\Utils{use
Nette;final
class
LimitedScope{private
static$vars;final
function
__construct(){throw
new
Nette\StaticClassException;}static
function
evaluate(){if(func_num_args()>1){self::$vars=func_get_arg(1);extract(self::$vars);}$res=eval('?>'.func_get_arg(0));if($res===FALSE&&($error=error_get_last())&&$error['type']===E_PARSE){throw
new
Nette\FatalErrorException($error['message'],0,$error['type'],$error['file'],$error['line'],NULL);}return$res;}static
function
load(){if(func_num_args()>1){self::$vars=func_get_arg(1);if(self::$vars===TRUE){return include_once func_get_arg(0);}extract(self::$vars);}return include func_get_arg(0);}}}namespace Nette\Loaders{use
Nette;abstract
class
AutoLoader
extends
Nette\Object{static
private$loaders=array();public
static$count=0;final
static
function
load($type){foreach(func_get_args()as$type){if(!class_exists($type)){throw
new
Nette\InvalidStateException("Unable to load class or interface '$type'.");}}}final
static
function
getLoaders(){return
array_values(self::$loaders);}function
register($prepend=FALSE){if(!function_exists('spl_autoload_register')){throw
new
Nette\NotSupportedException('spl_autoload does not exist in this PHP installation.');}spl_autoload_register(array($this,'tryLoad'),TRUE,(bool)$prepend);self::$loaders[spl_object_hash($this)]=$this;}function
unregister(){unset(self::$loaders[spl_object_hash($this)]);return
spl_autoload_unregister(array($this,'tryLoad'));}abstract
function
tryLoad($type);}}namespace Nette\Utils{use
Nette;final
class
SafeStream{const
PROTOCOL='safe';private$handle;private$tempHandle;private$file;private$tempFile;private$deleteFile;private$writeError=FALSE;static
function
register(){return
stream_wrapper_register(self::PROTOCOL,__CLASS__);}function
stream_open($path,$mode,$options,&$opened_path){$path=substr($path,strlen(self::PROTOCOL)+3);$flag=trim($mode,'crwax+');$mode=trim($mode,'tb');$use_path=(bool)(STREAM_USE_PATH&$options);if($mode==='r'){return$this->checkAndLock($this->tempHandle=fopen($path,'r'.$flag,$use_path),LOCK_SH);}elseif($mode==='r+'){if(!$this->checkAndLock($this->handle=fopen($path,'r'.$flag,$use_path),LOCK_EX)){return
FALSE;}}elseif($mode[0]==='x'){if(!$this->checkAndLock($this->handle=fopen($path,'x'.$flag,$use_path),LOCK_EX)){return
FALSE;}$this->deleteFile=TRUE;}elseif($mode[0]==='w'||$mode[0]==='a'||$mode[0]==='c'){if($this->checkAndLock($this->handle=@fopen($path,'x'.$flag,$use_path),LOCK_EX)){$this->deleteFile=TRUE;}elseif(!$this->checkAndLock($this->handle=fopen($path,'a+'.$flag,$use_path),LOCK_EX)){return
FALSE;}}else{trigger_error("Unknown mode $mode",E_USER_WARNING);return
FALSE;}$tmp='~~'.lcg_value().'.tmp';if(!$this->tempHandle=fopen($path.$tmp,(strpos($mode,'+')?'x+':'x').$flag,$use_path)){$this->clean();return
FALSE;}$this->tempFile=realpath($path.$tmp);$this->file=substr($this->tempFile,0,-strlen($tmp));if($mode==='r+'||$mode[0]==='a'||$mode[0]==='c'){$stat=fstat($this->handle);fseek($this->handle,0);if(stream_copy_to_stream($this->handle,$this->tempHandle)!==$stat['size']){$this->clean();return
FALSE;}if($mode[0]==='a'){fseek($this->tempHandle,0,SEEK_END);}}return
TRUE;}private
function
checkAndLock($handle,$lock){if(!$handle){return
FALSE;}elseif(!flock($handle,$lock)){fclose($handle);return
FALSE;}return
TRUE;}private
function
clean(){flock($this->handle,LOCK_UN);fclose($this->handle);if($this->deleteFile){unlink($this->file);}if($this->tempHandle){fclose($this->tempHandle);unlink($this->tempFile);}}function
stream_close(){if(!$this->tempFile){flock($this->tempHandle,LOCK_UN);fclose($this->tempHandle);return;}flock($this->handle,LOCK_UN);fclose($this->handle);fclose($this->tempHandle);if($this->writeError||!rename($this->tempFile,$this->file)){unlink($this->tempFile);if($this->deleteFile){unlink($this->file);}}}function
stream_read($length){return
fread($this->tempHandle,$length);}function
stream_write($data){$len=strlen($data);$res=fwrite($this->tempHandle,$data,$len);if($res!==$len){$this->writeError=TRUE;}return$res;}function
stream_tell(){return
ftell($this->tempHandle);}function
stream_eof(){return
feof($this->tempHandle);}function
stream_seek($offset,$whence){return
fseek($this->tempHandle,$offset,$whence)===0;}function
stream_stat(){return
fstat($this->tempHandle);}function
url_stat($path,$flags){$path=substr($path,strlen(self::PROTOCOL)+3);return($flags&STREAM_URL_STAT_LINK)?@lstat($path):@stat($path);}function
unlink($path){$path=substr($path,strlen(self::PROTOCOL)+3);return
unlink($path);}}}namespace Nette{use
Nette;use
Nette\DI;class
Configurator
extends
Object{const
DEVELOPMENT='development',PRODUCTION='production',AUTO=TRUE,NONE=FALSE;public$onCompile;protected$parameters;protected$files=array();function
__construct(){$this->parameters=$this->getDefaultParameters();}function
setDebugMode($value=TRUE){$this->parameters['debugMode']=is_string($value)||is_array($value)?static::detectDebugMode($value):(bool)$value;$this->parameters['productionMode']=!$this->parameters['debugMode'];return$this;}function
isDebugMode(){return$this->parameters['debugMode'];}function
setTempDirectory($path){$this->parameters['tempDir']=$path;return$this;}function
addParameters(array$params){$this->parameters=DI\Config\Helpers::merge($params,$this->parameters);return$this;}protected
function
getDefaultParameters(){$trace=debug_backtrace(PHP_VERSION_ID>=50306?DEBUG_BACKTRACE_IGNORE_ARGS:FALSE);$debugMode=static::detectDebugMode();return
array('appDir'=>isset($trace[1]['file'])?dirname($trace[1]['file']):NULL,'wwwDir'=>isset($_SERVER['SCRIPT_FILENAME'])?dirname($_SERVER['SCRIPT_FILENAME']):NULL,'debugMode'=>$debugMode,'productionMode'=>!$debugMode,'environment'=>$debugMode?'development':'production','consoleMode'=>PHP_SAPI==='cli','container'=>array('class'=>'SystemContainer','parent'=>'Nette\DI\Container'));}function
enableDebugger($logDirectory=NULL,$email=NULL){Nette\Diagnostics\Debugger::$strictMode=TRUE;Nette\Diagnostics\Debugger::enable(!$this->parameters['debugMode'],$logDirectory,$email);}function
createRobotLoader(){$loader=new
Nette\Loaders\RobotLoader;$loader->setCacheStorage(new
Nette\Caching\Storages\FileStorage($this->getCacheDirectory()));$loader->autoRebuild=$this->parameters['debugMode'];return$loader;}function
addConfig($file,$section=NULL){$this->files[]=array($file,$section===self::AUTO?$this->parameters['environment']:$section);return$this;}function
createContainer(){$cache=new
Nette\Caching\Cache(new
Nette\Caching\Storages\PhpFileStorage($this->getCacheDirectory()),'Nette.Configurator');$cacheKey=array($this->parameters,$this->files);$cached=$cache->load($cacheKey);if(!$cached){$code=$this->buildContainer($dependencies);$cache->save($cacheKey,$code,array($cache::FILES=>$dependencies));$cached=$cache->load($cacheKey);}Nette\Utils\LimitedScope::load($cached['file'],TRUE);$container=new$this->parameters['container']['class'];$container->initialize();Nette\Environment::setContext($container);return$container;}protected
function
buildContainer(&$dependencies=NULL){$loader=$this->createLoader();$config=array();$code="<?php\n";foreach($this->files
as$tmp){list($file,$section)=$tmp;$code.="// source: $file $section\n";try{if($section===NULL){$config=DI\Config\Helpers::merge($loader->load($file,$this->parameters['environment']),$config);continue;}}catch(Nette\InvalidStateException$e){}catch(Nette\Utils\AssertionException$e){}$config=DI\Config\Helpers::merge($loader->load($file,$section),$config);}$code.="\n";if(!isset($config['parameters'])){$config['parameters']=array();}$config['parameters']=DI\Config\Helpers::merge($config['parameters'],$this->parameters);$compiler=$this->createCompiler();$this->onCompile($this,$compiler);$code.=$compiler->compile($config,$this->parameters['container']['class'],$config['parameters']['container']['parent']);$dependencies=array_merge($loader->getDependencies(),$this->parameters['debugMode']?$compiler->getContainerBuilder()->getDependencies():array());return$code;}protected
function
createCompiler(){$compiler=new
DI\Compiler;$compiler->addExtension('php',new
DI\Extensions\PhpExtension)->addExtension('constants',new
DI\Extensions\ConstantsExtension)->addExtension('nette',new
DI\Extensions\NetteExtension)->addExtension('extensions',new
DI\Extensions\ExtensionsExtension);return$compiler;}protected
function
createLoader(){return
new
DI\Config\Loader;}protected
function
getCacheDirectory(){if(empty($this->parameters['tempDir'])){throw
new
Nette\InvalidStateException("Set path to temporary directory using setTempDirectory().");}$dir=$this->parameters['tempDir'].'/cache';if(!is_dir($dir)){mkdir($dir);}return$dir;}static
function
detectDebugMode($list=NULL){$list=is_string($list)?preg_split('#[,\s]+#',$list):(array)$list;if(!isset($_SERVER['HTTP_X_FORWARDED_FOR'])){$list[]='127.0.0.1';$list[]='::1';}return
in_array(isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:php_uname('n'),$list,TRUE);}function
setProductionMode($value=TRUE){trigger_error(__METHOD__.'() is deprecated; use setDebugMode(!$value) instead.',E_USER_DEPRECATED);return$this->setDebugMode(is_bool($value)?!$value:$value);}function
isProductionMode(){trigger_error(__METHOD__.'() is deprecated; use !isDebugMode() instead.',E_USER_DEPRECATED);return!$this->isDebugMode();}static
function
detectProductionMode($list=NULL){trigger_error(__METHOD__.'() is deprecated; use !detectDebugMode() instead.',E_USER_DEPRECATED);return!static::detectDebugMode($list);}}}namespace Nette\Application{use
Nette;class
Application
extends
Nette\Object{public
static$maxLoop=20;public$catchExceptions;public$errorPresenter;public$onStartup;public$onShutdown;public$onRequest;public$onResponse;public$onError;private$requests=array();private$presenter;private$httpRequest;private$httpResponse;private$presenterFactory;private$router;function
__construct(IPresenterFactory$presenterFactory,IRouter$router,Nette\Http\IRequest$httpRequest,Nette\Http\IResponse$httpResponse){$this->httpRequest=$httpRequest;$this->httpResponse=$httpResponse;$this->presenterFactory=$presenterFactory;$this->router=$router;}function
run(){try{$this->onStartup($this);$this->processRequest($this->createInitialRequest());$this->onShutdown($this);}catch(\Exception$e){$this->onError($this,$e);if($this->catchExceptions&&$this->errorPresenter){try{$this->processException($e);$this->onShutdown($this,$e);return;}catch(\Exception$e){$this->onError($this,$e);}}$this->onShutdown($this,$e);throw$e;}}function
createInitialRequest(){$request=$this->router->match($this->httpRequest);if(!$request
instanceof
Request){throw
new
BadRequestException('No route for HTTP request.');}elseif(strcasecmp($request->getPresenterName(),$this->errorPresenter)===0){throw
new
BadRequestException('Invalid request. Presenter is not achievable.');}try{$name=$request->getPresenterName();$this->presenterFactory->getPresenterClass($name);$request->setPresenterName($name);}catch(InvalidPresenterException$e){throw
new
BadRequestException($e->getMessage(),0,$e);}return$request;}function
processRequest(Request$request){if(count($this->requests)>self::$maxLoop){throw
new
ApplicationException('Too many loops detected in application life cycle.');}$this->requests[]=$request;$this->onRequest($this,$request);$this->presenter=$this->presenterFactory->createPresenter($request->getPresenterName());$response=$this->presenter->run($request);if($response
instanceof
Responses\ForwardResponse){$this->processRequest($response->getRequest());}elseif($response){$this->onResponse($this,$response);$response->send($this->httpRequest,$this->httpResponse);}}function
processException(\Exception$e){if(!$this->httpResponse->isSent()){$this->httpResponse->setCode($e
instanceof
BadRequestException?($e->getCode()?:404):500);}$args=array('exception'=>$e,'request'=>end($this->requests));if($this->presenter
instanceof
UI\Presenter){try{$this->presenter->forward(":$this->errorPresenter:",$args);}catch(AbortException$foo){$this->processRequest($this->presenter->getLastCreatedRequest());}}else{$this->processRequest(new
Request($this->errorPresenter,Request::FORWARD,$args));}}final
function
getRequests(){return$this->requests;}final
function
getPresenter(){return$this->presenter;}function
getRouter(){return$this->router;}function
getPresenterFactory(){return$this->presenterFactory;}function
storeRequest($expiration='+ 10 minutes'){trigger_error(__METHOD__.'() is deprecated; use $presenter->storeRequest() instead.',E_USER_DEPRECATED);return$this->presenter->storeRequest($expiration);}function
restoreRequest($key){trigger_error(__METHOD__.'() is deprecated; use $presenter->restoreRequest() instead.',E_USER_DEPRECATED);return$this->presenter->restoreRequest($key);}}}namespace Nette\Application\Diagnostics{use
Nette;use
Nette\Application\Routers;use
Nette\Application\UI\Presenter;use
Nette\Diagnostics\Dumper;class
RoutingPanel
extends
Nette\Object
implements
Nette\Diagnostics\IBarPanel{private$router;private$httpRequest;private$routers=array();private$request;static
function
initializePanel(Nette\Application\Application$application){Nette\Diagnostics\Debugger::getBlueScreen()->addPanel(function($e)use($application){return$e?NULL:array('tab'=>'Nette Application','panel'=>'<h3>Requests</h3>'.Dumper::toHtml($application->getRequests()).'<h3>Presenter</h3>'.Dumper::toHtml($application->getPresenter()));});}function
__construct(Nette\Application\IRouter$router,Nette\Http\IRequest$httpRequest){$this->router=$router;$this->httpRequest=$httpRequest;}function
getTab(){$this->analyse($this->router);ob_start();?>
<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAJHSURBVDjLlZPNi81hFMc/z7137p1mTCFvNZfGSzLIWNjZKRvFRoqNhRCSYm8xS3+AxRRZ2JAFJWJHSQqTQkbEzYwIM+6Yid/znJfH4prLXShOnb6r8/nWOd8Tcs78bz0/f+KMu50y05nK/wy+uHDylbutqS5extvGcxaWqtoGDA8PZ3dnrs2srQc2Zko41UXLmLdyDW5OfvsUkUgbYGbU63UAQggdmvMzFmzZCgTi7CQmkZwdEaX0JwDgTnGbTCaE0G4zw80omhPI92lcEtkNkdgJCCHwJX7mZvNaB0A14SaYJlwTrpHsTkoFlV1nt2c3x5YYo1/vM9A/gKpxdfwyu/v3teCayKq4JEwT5EB2R6WgYmrs2bYbcUNNUVfEhIfFYy69uci+1fuRX84mkawFSxd/4nVWUopUVIykwlQxRTJBTIDA4Pp1jBZPuNW4wUAPmCqWIn29X1k4f5Ku8g9mpKCkakRLVEs1auVuauVuyqHMo8ejNCe+sWPVTkQKXCMmkeZUmUZjETF1tc6ooly+fgUVw9So1/tRN6YnZji46QghBFKKuAouERNhMlbAHZFE6e7pB+He8MMw+GGI4xtOMf1+lsl3TQ4NHf19BSlaO1DB9BfMHdX0O0iqSgiBbJkjm491hClJbA1LxCURgpPzXwAHhg63necAIi3XngXLcRU0fof8ETMljIyM5LGxMcbHxzvy/6fuXdWgt6+PWncv1e4euqo1ZmabvHs5+jn8yzufO7hiiZmuNpNBM13rbvVSpbrXJE7/BMkHtU9jFIC/AAAAAElFTkSuQmCC"
/><?php if(empty($this->request)):?>no route<?php else:echo
htmlSpecialChars($this->request->getPresenterName().':'.(isset($this->request->parameters[Presenter::ACTION_KEY])?$this->request->parameters[Presenter::ACTION_KEY]:Presenter::DEFAULT_ACTION).(isset($this->request->parameters[Presenter::SIGNAL_KEY])?" {$this->request->parameters[Presenter::SIGNAL_KEY]}!":''));endif?>
<?php
return
ob_get_clean();}function
getPanel(){ob_start();?>
<style class="nette-debug">#nette-debug .nette-RoutingPanel table{font:9pt/1.5 Consolas,monospace}#nette-debug .nette-RoutingPanel .yes td{color:green}#nette-debug .nette-RoutingPanel .may td{color:#67F}#nette-debug .nette-RoutingPanel pre,#nette-debug .nette-RoutingPanel code{display:inline}#nette-debug .nette-RoutingPanel code .nette-collapsed{display:none}</style>

<div class="nette-RoutingPanel">
<h1>
<?php if(empty($this->request)):?>
	no route
<?php else:?>
	<?php echo
htmlSpecialChars($this->request->getPresenterName().':'.(isset($this->request->parameters[Presenter::ACTION_KEY])?$this->request->parameters[Presenter::ACTION_KEY]:Presenter::DEFAULT_ACTION).(isset($this->request->parameters[Presenter::SIGNAL_KEY])?" {$this->request->parameters[Presenter::SIGNAL_KEY]}!":''))?>
<?php endif?>
</h1>

<?php if(!empty($this->request)):?>
	<?php $params=$this->request->getParameters()?>
	<?php if(empty($params)):?>
		<p>No parameters.</p>

	<?php else:?>
		<table>
		<thead>
		<tr>
			<th>Parameter</th>
			<th>Value</th>
		</tr>
		</thead>
		<tbody>
		<?php unset($params[Presenter::ACTION_KEY],$params[Presenter::SIGNAL_KEY])?>
		<?php foreach($params
as$key=>$value):?>
		<tr>
			<td><code><?php echo
htmlSpecialChars($key)?></code></td>
			<td><?php if(is_string($value)):?><code><?php echo
htmlSpecialChars($value)?></code><?php else:echo
Dumper::toHtml($value);endif?></td>
		</tr>
		<?php endforeach?>
		</tbody>
		</table>
	<?php endif?>
<?php endif?>

<h2>Routers</h2>

<?php if(empty($this->routers)):?>
	<p>No routers defined.</p>

<?php else:?>
	<div class="nette-inner">
	<table>
	<thead>
	<tr>
		<th>Matched?</th>
		<th>Class</th>
		<th>Mask</th>
		<th>Defaults</th>
		<th>Module</th>
		<th>Request</th>
	</tr>
	</thead>

	<tbody>
	<?php foreach($this->routers
as$router):?>
	<tr class="<?php echo$router['matched']?>">
		<td><?php echo$router['matched']?></td>

		<td><code title="<?php echo
htmlSpecialChars($router['class'])?>"><?php echo
preg_replace('#.+\\\\#','',htmlSpecialChars($router['class']))?></code></td>

		<td><code><strong><?php echo
htmlSpecialChars($router['mask'])?></strong></code></td>

		<td><code>
		<?php foreach($router['defaults']as$key=>$value):?>
			<?php echo
htmlSpecialChars($key),"&nbsp;=&nbsp;",is_string($value)?htmlSpecialChars($value):str_replace("\n</pre",'</pre',Dumper::toHtml($value,array(Dumper::COLLAPSE=>TRUE)))?><br />
		<?php endforeach?>
		</code></td>

		<td><code><?php echo
htmlSpecialChars($router['module'])?></code></td>

		<td><?php if($router['request']):?><code>
		<?php $params=$router['request']->getParameters();?>
		<strong><?php echo
htmlSpecialChars($router['request']->getPresenterName().':'.(isset($params[Presenter::ACTION_KEY])?$params[Presenter::ACTION_KEY]:Presenter::DEFAULT_ACTION))?></strong><br />
		<?php unset($params[Presenter::ACTION_KEY])?>
		<?php foreach($params
as$key=>$value):?>
			<?php echo
htmlSpecialChars($key),"&nbsp;=&nbsp;",is_string($value)?htmlSpecialChars($value):str_replace("\n</pre",'</pre',Dumper::toHtml($value,array(Dumper::COLLAPSE=>TRUE)))?><br />
		<?php endforeach?>
		</code><?php endif?></td>
	</tr>
	<?php endforeach?>
	</tbody>
	</table>
	</div>
<?php endif?>
</div>
<?php
return
ob_get_clean();}private
function
analyse($router,$module=''){if($router
instanceof
Routers\RouteList){foreach($router
as$subRouter){$this->analyse($subRouter,$module.$router->getModule());}return;}$matched='no';$request=$router->match($this->httpRequest);if($request){$request->setPresenterName($module.$request->getPresenterName());$matched='may';if(empty($this->request)){$this->request=$request;$matched='yes';}}$this->routers[]=array('matched'=>$matched,'class'=>get_class($router),'defaults'=>$router
instanceof
Routers\Route||$router
instanceof
Routers\SimpleRouter?$router->getDefaults():array(),'mask'=>$router
instanceof
Routers\Route?$router->getMask():NULL,'request'=>$request,'module'=>rtrim($module,':'));}}}namespace NetteModule{use
Nette;use
Nette\Application;use
Nette\Diagnostics\Debugger;class
ErrorPresenter
extends
Nette\Object
implements
Application\IPresenter{function
run(Application\Request$request){$e=$request->parameters['exception'];if($e
instanceof
Application\BadRequestException){$code=$e->getCode();}else{$code=500;Debugger::log($e,Debugger::ERROR);}ob_start();$messages=array(0=>array('Oops...','Your browser sent a request that this server could not understand or process.'),403=>array('Access Denied','You do not have permission to view this page. Please try contact the web site administrator if you believe you should be able to view this page.'),404=>array('Page Not Found','The page you requested could not be found. It is possible that the address is incorrect, or that the page no longer exists. Please use a search engine to find what you are looking for.'),405=>array('Method Not Allowed','The requested method is not allowed for the URL.'),410=>array('Page Not Found','The page you requested has been taken off the site. We apologize for the inconvenience.'),500=>array('Server Error','We\'re sorry! The server encountered an internal error and was unable to complete your request. Please try again later.'));$message=isset($messages[$code])?$messages[$code]:$messages[0];?>
<!DOCTYPE html>
<meta charset="utf-8">
<meta name=robots content=noindex>
<meta name=generator content="Nette Framework">
<style>body{color:#333;background:white;width:500px;margin:100px auto}h1{font:bold 47px/1.5 sans-serif;margin:.6em 0}p{font:21px/1.5 Georgia,serif;margin:1.5em 0}small{font-size:70%;color:gray}</style>

<title><?php echo$message[0]?></title>

<h1><?php echo$message[0]?></h1>

<p><?php echo$message[1]?></p>

<?php if($code):?><p><small>error <?php echo$code?></small></p><?php endif?>
<?php
return
new
Application\Responses\TextResponse(ob_get_clean());}}}namespace Nette\Application{use
Nette;class
AbortException
extends\Exception{}class
ApplicationException
extends\Exception{}class
InvalidPresenterException
extends\Exception{}class
BadRequestException
extends\Exception{protected$defaultCode=404;function
__construct($message='',$code=0,\Exception$previous=NULL){parent::__construct($message,$code<200||$code>504?$this->defaultCode:$code,$previous);}}class
ForbiddenRequestException
extends
BadRequestException{protected$defaultCode=403;}}namespace NetteModule{use
Nette;use
Nette\Application;use
Nette\Application\Responses;use
Nette\Http;class
MicroPresenter
extends
Nette\Object
implements
Application\IPresenter{private$context;private$request;function
__construct(Nette\DI\Container$context){$this->context=$context;}final
function
getContext(){return$this->context;}function
run(Application\Request$request){$this->request=$request;$httpRequest=$this->context->getByType('Nette\Http\IRequest');if(!$httpRequest->isAjax()&&($request->isMethod('get')||$request->isMethod('head'))){$refUrl=clone$httpRequest->getUrl();$url=$this->context->getService('router')->constructUrl($request,$refUrl->setPath($refUrl->getScriptPath()));if($url!==NULL&&!$httpRequest->getUrl()->isEqual($url)){return
new
Responses\RedirectResponse($url,Http\IResponse::S301_MOVED_PERMANENTLY);}}$params=$request->getParameters();if(!isset($params['callback'])){throw
new
Application\BadRequestException("Parameter callback is missing.");}$params['presenter']=$this;$callback=$params['callback'];$reflection=Nette\Utils\Callback::toReflection(Nette\Utils\Callback::check($callback));$params=Application\UI\PresenterComponentReflection::combineArgs($reflection,$params);foreach($reflection->getParameters()as$param){if($param->getClassName()){unset($params[$param->getPosition()]);}}$params=Nette\DI\Helpers::autowireArguments($reflection,$params,$this->context);$response=call_user_func_array($callback,$params);if(is_string($response)){$response=array($response,array());}if(is_array($response)){if($response[0]instanceof\SplFileInfo){$response=$this->createTemplate('Nette\Templating\FileTemplate')->setParameters($response[1])->setFile($response[0]);}else{$response=$this->createTemplate('Nette\Templating\Template')->setParameters($response[1])->setSource($response[0]);}}if($response
instanceof
Nette\Templating\ITemplate){return
new
Responses\TextResponse($response);}else{return$response;}}function
createTemplate($class=NULL,$latteFactory=NULL){$template=$class?new$class:new
Nette\Templating\FileTemplate;$template->setParameters($this->request->getParameters());$template->presenter=$this;$template->context=$context=$this->context;$url=$context->getByType('Nette\Http\IRequest')->getUrl();$template->baseUrl=rtrim($url->getBaseUrl(),'/');$template->basePath=rtrim($url->getBasePath(),'/');$template->registerHelperLoader('Nette\Templating\Helpers::loader');$template->setCacheStorage($context->getService('nette.templateCacheStorage'));$template->onPrepareFilters[]=function($template)use($latteFactory){$template->registerFilter($latteFactory?$latteFactory():new
Nette\Latte\Engine);};return$template;}function
redirectUrl($url,$code=Http\IResponse::S302_FOUND){return
new
Responses\RedirectResponse($url,$code);}function
error($message=NULL,$code=Http\IResponse::S404_NOT_FOUND){throw
new
Application\BadRequestException($message,$code);}function
getRequest(){return$this->request;}}}namespace Nette\Application{use
Nette;class
PresenterFactory
extends
Nette\Object
implements
IPresenterFactory{public$caseSensitive=FALSE;private$mapping=array('*'=>array('','*Module\\','*Presenter'),'Nette'=>array('NetteModule\\','*\\','*Presenter'));private$baseDir;private$cache=array();private$container;function
__construct($baseDir,Nette\DI\Container$container){$this->baseDir=$baseDir;$this->container=$container;}function
createPresenter($name){$class=$this->getPresenterClass($name);if(count($services=$this->container->findByType($class))===1){$presenter=$this->container->createService($services[0]);}else{$presenter=$this->container->createInstance($class);$this->container->callInjects($presenter);}if($presenter
instanceof
UI\Presenter&&$presenter->invalidLinkMode===NULL){$presenter->invalidLinkMode=$this->container->parameters['debugMode']?UI\Presenter::INVALID_LINK_WARNING:UI\Presenter::INVALID_LINK_SILENT;}return$presenter;}function
getPresenterClass(&$name){if(isset($this->cache[$name])){list($class,$name)=$this->cache[$name];return$class;}if(!is_string($name)||!Nette\Utils\Strings::match($name,'#^[a-zA-Z\x7f-\xff][a-zA-Z0-9\x7f-\xff:]*\z#')){throw
new
InvalidPresenterException("Presenter name must be alphanumeric string, '$name' is invalid.");}$class=$this->formatPresenterClass($name);if(!class_exists($class)){$file=$this->formatPresenterFile($name);if(is_file($file)&&is_readable($file)){Nette\Utils\LimitedScope::load($file,TRUE);}if(!class_exists($class)){throw
new
InvalidPresenterException("Cannot load presenter '$name', class '$class' was not found in '$file'.");}}$reflection=new
Nette\Reflection\ClassType($class);$class=$reflection->getName();if(!$reflection->implementsInterface('Nette\Application\IPresenter')){throw
new
InvalidPresenterException("Cannot load presenter '$name', class '$class' is not Nette\\Application\\IPresenter implementor.");}if($reflection->isAbstract()){throw
new
InvalidPresenterException("Cannot load presenter '$name', class '$class' is abstract.");}$realName=$this->unformatPresenterClass($class);if($name!==$realName){if($this->caseSensitive){throw
new
InvalidPresenterException("Cannot load presenter '$name', case mismatch. Real name is '$realName'.");}else{$this->cache[$name]=array($class,$realName);$name=$realName;}}else{$this->cache[$name]=array($class,$realName);}return$class;}function
setMapping(array$mapping){foreach($mapping
as$module=>$mask){if(!preg_match('#^\\\\?([\w\\\\]*\\\\)?(\w*\*\w*?\\\\)?([\w\\\\]*\*\w*)\z#',$mask,$m)){throw
new
Nette\InvalidStateException("Invalid mapping mask '$mask'.");}$this->mapping[$module]=array($m[1],$m[2]?:'*Module\\',$m[3]);}return$this;}function
formatPresenterClass($presenter){$parts=explode(':',$presenter);$mapping=isset($parts[1],$this->mapping[$parts[0]])?$this->mapping[array_shift($parts)]:$this->mapping['*'];while($part=array_shift($parts)){$mapping[0].=str_replace('*',$part,$mapping[$parts?1:2]);}return$mapping[0];}function
unformatPresenterClass($class){foreach($this->mapping
as$module=>$mapping){$mapping=str_replace(array('\\','*'),array('\\\\','(\w+)'),$mapping);if(preg_match("#^\\\\?$mapping[0]((?:$mapping[1])*)$mapping[2]\\z#i",$class,$matches)){return($module==='*'?'':$module.':').preg_replace("#$mapping[1]#iA",'$1:',$matches[1]).$matches[3];}}}function
formatPresenterFile($presenter){$path='/'.str_replace(':','Module/',$presenter);return$this->baseDir.substr_replace($path,'/presenters',strrpos($path,'/'),0).'Presenter.php';}}final
class
Request
extends
Nette\Object{const
FORWARD='FORWARD';const
SECURED='secured';const
RESTORED='restored';private$method;private$flags=array();private$name;private$params;private$post;private$files;function
__construct($name,$method,array$params,array$post=array(),array$files=array(),array$flags=array()){$this->name=$name;$this->method=$method;$this->params=$params;$this->post=$post;$this->files=$files;$this->flags=$flags;}function
setPresenterName($name){$this->name=$name;return$this;}function
getPresenterName(){return$this->name;}function
setParameters(array$params){$this->params=$params;return$this;}function
getParameters(){return$this->params;}function
setPost(array$params){$this->post=$params;return$this;}function
getPost(){return$this->post;}function
setFiles(array$files){$this->files=$files;return$this;}function
getFiles(){return$this->files;}function
setMethod($method){$this->method=$method;return$this;}function
getMethod(){return$this->method;}function
isMethod($method){return
strcasecmp($this->method,$method)===0;}function
isPost(){return
strcasecmp($this->method,'post')===0;}function
setFlag($flag,$value=TRUE){$this->flags[$flag]=(bool)$value;return$this;}function
hasFlag($flag){return!empty($this->flags[$flag]);}}}namespace Nette\Application\Responses{use
Nette;class
FileResponse
extends
Nette\Object
implements
Nette\Application\IResponse{private$file;private$contentType;private$name;public$resuming=TRUE;function
__construct($file,$name=NULL,$contentType=NULL){if(!is_file($file)){throw
new
Nette\Application\BadRequestException("File '$file' doesn't exist.");}$this->file=$file;$this->name=$name?$name:basename($file);$this->contentType=$contentType?$contentType:'application/octet-stream';}final
function
getFile(){return$this->file;}final
function
getName(){return$this->name;}final
function
getContentType(){return$this->contentType;}function
send(Nette\Http\IRequest$httpRequest,Nette\Http\IResponse$httpResponse){$httpResponse->setContentType($this->contentType);$httpResponse->setHeader('Content-Disposition','attachment; filename="'.$this->name.'"');$filesize=$length=filesize($this->file);$handle=fopen($this->file,'r');if($this->resuming){$httpResponse->setHeader('Accept-Ranges','bytes');if(preg_match('#^bytes=(\d*)-(\d*)\z#',$httpRequest->getHeader('Range'),$matches)){list(,$start,$end)=$matches;if($start===''){$start=max(0,$filesize-$end);$end=$filesize-1;}elseif($end===''||$end>$filesize-1){$end=$filesize-1;}if($end<$start){$httpResponse->setCode(416);return;}$httpResponse->setCode(206);$httpResponse->setHeader('Content-Range','bytes '.$start.'-'.$end.'/'.$filesize);$length=$end-$start+1;fseek($handle,$start);}else{$httpResponse->setHeader('Content-Range','bytes 0-'.($filesize-1).'/'.$filesize);}}$httpResponse->setHeader('Content-Length',$length);while(!feof($handle)&&$length>0){echo$s=fread($handle,min(4e6,$length));$length-=strlen($s);}fclose($handle);}}class
ForwardResponse
extends
Nette\Object
implements
Nette\Application\IResponse{private$request;function
__construct(Nette\Application\Request$request){$this->request=$request;}final
function
getRequest(){return$this->request;}function
send(Nette\Http\IRequest$httpRequest,Nette\Http\IResponse$httpResponse){}}class
JsonResponse
extends
Nette\Object
implements
Nette\Application\IResponse{private$payload;private$contentType;function
__construct($payload,$contentType=NULL){if(!is_array($payload)&&!is_object($payload)){throw
new
Nette\InvalidArgumentException("Payload must be array or object class, ".gettype($payload)." given.");}$this->payload=$payload;$this->contentType=$contentType?$contentType:'application/json';}final
function
getPayload(){return$this->payload;}final
function
getContentType(){return$this->contentType;}function
send(Nette\Http\IRequest$httpRequest,Nette\Http\IResponse$httpResponse){$httpResponse->setContentType($this->contentType);$httpResponse->setExpiration(FALSE);echo
Nette\Utils\Json::encode($this->payload);}}use
Nette\Http;class
RedirectResponse
extends
Nette\Object
implements
Nette\Application\IResponse{private$url;private$code;function
__construct($url,$code=Http\IResponse::S302_FOUND){$this->url=(string)$url;$this->code=(int)$code;}final
function
getUrl(){return$this->url;}final
function
getCode(){return$this->code;}function
send(Http\IRequest$httpRequest,Http\IResponse$httpResponse){$httpResponse->redirect($this->url,$this->code);}}class
TextResponse
extends
Nette\Object
implements
Nette\Application\IResponse{private$source;function
__construct($source){$this->source=$source;}final
function
getSource(){return$this->source;}function
send(Nette\Http\IRequest$httpRequest,Nette\Http\IResponse$httpResponse){if($this->source
instanceof
Nette\Templating\ITemplate){$this->source->render();}else{echo$this->source;}}}}namespace Nette\Application\Routers{use
Nette;use
Nette\Application;class
CliRouter
extends
Nette\Object
implements
Application\IRouter{const
PRESENTER_KEY='action';private$defaults;function
__construct($defaults=array()){$this->defaults=$defaults;}function
match(Nette\Http\IRequest$httpRequest){if(empty($_SERVER['argv'])||!is_array($_SERVER['argv'])){return
NULL;}$names=array(self::PRESENTER_KEY);$params=$this->defaults;$args=$_SERVER['argv'];array_shift($args);$args[]='--';foreach($args
as$arg){$opt=preg_replace('#/|-+#A','',$arg);if($opt===$arg){if(isset($flag)||$flag=array_shift($names)){$params[$flag]=$arg;}else{$params[]=$arg;}$flag=NULL;continue;}if(isset($flag)){$params[$flag]=TRUE;$flag=NULL;}if($opt!==''){$pair=explode('=',$opt,2);if(isset($pair[1])){$params[$pair[0]]=$pair[1];}else{$flag=$pair[0];}}}if(!isset($params[self::PRESENTER_KEY])){throw
new
Nette\InvalidStateException('Missing presenter & action in route definition.');}$presenter=$params[self::PRESENTER_KEY];if($a=strrpos($presenter,':')){$params[self::PRESENTER_KEY]=substr($presenter,$a+1);$presenter=substr($presenter,0,$a);}return
new
Application\Request($presenter,'CLI',$params);}function
constructUrl(Application\Request$appRequest,Nette\Http\Url$refUrl){return
NULL;}function
getDefaults(){return$this->defaults;}}use
Nette\Utils\Strings;class
Route
extends
Nette\Object
implements
Application\IRouter{const
PRESENTER_KEY='presenter';const
MODULE_KEY='module';const
CASE_SENSITIVE=256;const
HOST=1,PATH=2,RELATIVE=3;const
VALUE='value';const
PATTERN='pattern';const
FILTER_IN='filterIn';const
FILTER_OUT='filterOut';const
FILTER_TABLE='filterTable';const
FILTER_STRICT='filterStrict';const
OPTIONAL=0,PATH_OPTIONAL=1,CONSTANT=2;public
static$defaultFlags=0;public
static$styles=array('#'=>array(self::PATTERN=>'[^/]+',self::FILTER_IN=>'rawurldecode',self::FILTER_OUT=>array(__CLASS__,'param2path')),'?#'=>array(),'module'=>array(self::PATTERN=>'[a-z][a-z0-9.-]*',self::FILTER_IN=>array(__CLASS__,'path2presenter'),self::FILTER_OUT=>array(__CLASS__,'presenter2path')),'presenter'=>array(self::PATTERN=>'[a-z][a-z0-9.-]*',self::FILTER_IN=>array(__CLASS__,'path2presenter'),self::FILTER_OUT=>array(__CLASS__,'presenter2path')),'action'=>array(self::PATTERN=>'[a-z][a-z0-9-]*',self::FILTER_IN=>array(__CLASS__,'path2action'),self::FILTER_OUT=>array(__CLASS__,'action2path')),'?module'=>array(),'?presenter'=>array(),'?action'=>array());private$mask;private$sequence;private$re;private$metadata=array();private$xlat;private$type;private$flags;function
__construct($mask,$metadata=array(),$flags=0){if(is_string($metadata)){$a=strrpos($metadata,':');if(!$a){throw
new
Nette\InvalidArgumentException("Second argument must be array or string in format Presenter:action, '$metadata' given.");}$metadata=array(self::PRESENTER_KEY=>substr($metadata,0,$a),'action'=>$a===strlen($metadata)-1?NULL:substr($metadata,$a+1));}elseif($metadata
instanceof\Closure||$metadata
instanceof
Nette\Callback){$metadata=array(self::PRESENTER_KEY=>'Nette:Micro','callback'=>$metadata);}$this->flags=$flags|static::$defaultFlags;$this->setMask($mask,$metadata);}function
match(Nette\Http\IRequest$httpRequest){$url=$httpRequest->getUrl();$re=$this->re;if($this->type===self::HOST){$path='//'.$url->getHost().$url->getPath();$host=array_reverse(explode('.',$url->getHost()));$re=strtr($re,array('/%basePath%/'=>preg_quote($url->getBasePath(),'#'),'%tld%'=>$host[0],'%domain%'=>isset($host[1])?"$host[1]\\.$host[0]":$host[0]));}elseif($this->type===self::RELATIVE){$basePath=$url->getBasePath();if(strncmp($url->getPath(),$basePath,strlen($basePath))!==0){return
NULL;}$path=(string)substr($url->getPath(),strlen($basePath));}else{$path=$url->getPath();}if($path!==''){$path=rtrim($path,'/').'/';}if(!$matches=Strings::match($path,$re)){return
NULL;}$params=array();foreach($matches
as$k=>$v){if(is_string($k)&&$v!==''){$params[str_replace('___','-',$k)]=$v;}}foreach($this->metadata
as$name=>$meta){if(isset($params[$name])){}elseif(isset($meta['fixity'])&&$meta['fixity']!==self::OPTIONAL){$params[$name]=NULL;}}if($this->xlat){$params+=self::renameKeys($httpRequest->getQuery(),array_flip($this->xlat));}else{$params+=$httpRequest->getQuery();}foreach($this->metadata
as$name=>$meta){if(isset($params[$name])){if(!is_scalar($params[$name])){}elseif(isset($meta[self::FILTER_TABLE][$params[$name]])){$params[$name]=$meta[self::FILTER_TABLE][$params[$name]];}elseif(isset($meta[self::FILTER_TABLE])&&!empty($meta[self::FILTER_STRICT])){return
NULL;}elseif(isset($meta[self::FILTER_IN])){$params[$name]=call_user_func($meta[self::FILTER_IN],(string)$params[$name]);if($params[$name]===NULL&&!isset($meta['fixity'])){return
NULL;}}}elseif(isset($meta['fixity'])){$params[$name]=$meta[self::VALUE];}}if(isset($this->metadata[NULL][self::FILTER_IN])){$params=call_user_func($this->metadata[NULL][self::FILTER_IN],$params);}if(!isset($params[self::PRESENTER_KEY])){throw
new
Nette\InvalidStateException('Missing presenter in route definition.');}elseif(!is_string($params[self::PRESENTER_KEY])){return
NULL;}if(isset($this->metadata[self::MODULE_KEY])){if(!isset($params[self::MODULE_KEY])){throw
new
Nette\InvalidStateException('Missing module in route definition.');}$presenter=$params[self::MODULE_KEY].':'.$params[self::PRESENTER_KEY];unset($params[self::MODULE_KEY],$params[self::PRESENTER_KEY]);}else{$presenter=$params[self::PRESENTER_KEY];unset($params[self::PRESENTER_KEY]);}return
new
Application\Request($presenter,$httpRequest->getMethod(),$params,$httpRequest->getPost(),$httpRequest->getFiles(),array(Application\Request::SECURED=>$httpRequest->isSecured()));}function
constructUrl(Application\Request$appRequest,Nette\Http\Url$refUrl){if($this->flags&self::ONE_WAY){return
NULL;}$params=$appRequest->getParameters();$metadata=$this->metadata;$presenter=$appRequest->getPresenterName();$params[self::PRESENTER_KEY]=$presenter;if(isset($metadata[NULL][self::FILTER_OUT])){$params=call_user_func($metadata[NULL][self::FILTER_OUT],$params);}if(isset($metadata[self::MODULE_KEY])){$module=$metadata[self::MODULE_KEY];if(isset($module['fixity'])&&strncasecmp($presenter,$module[self::VALUE].':',strlen($module[self::VALUE])+1)===0){$a=strlen($module[self::VALUE]);}else{$a=strrpos($presenter,':');}if($a===FALSE){$params[self::MODULE_KEY]='';}else{$params[self::MODULE_KEY]=substr($presenter,0,$a);$params[self::PRESENTER_KEY]=substr($presenter,$a+1);}}foreach($metadata
as$name=>$meta){if(!isset($params[$name])){continue;}if(isset($meta['fixity'])){if($params[$name]===FALSE){$params[$name]='0';}if(is_scalar($params[$name])?strcasecmp($params[$name],$meta[self::VALUE])===0:$params[$name]===$meta[self::VALUE]){unset($params[$name]);continue;}elseif($meta['fixity']===self::CONSTANT){return
NULL;}}if(is_scalar($params[$name])&&isset($meta['filterTable2'][$params[$name]])){$params[$name]=$meta['filterTable2'][$params[$name]];}elseif(isset($meta['filterTable2'])&&!empty($meta[self::FILTER_STRICT])){return
NULL;}elseif(isset($meta[self::FILTER_OUT])){$params[$name]=call_user_func($meta[self::FILTER_OUT],$params[$name]);}if(isset($meta[self::PATTERN])&&!preg_match($meta[self::PATTERN],rawurldecode($params[$name]))){return
NULL;}}$sequence=$this->sequence;$brackets=array();$required=NULL;$url='';$i=count($sequence)-1;do{$url=$sequence[$i].$url;if($i===0){break;}$i--;$name=$sequence[$i];$i--;if($name===']'){$brackets[]=$url;}elseif($name[0]==='['){$tmp=array_pop($brackets);if($required<count($brackets)+1){if($name!=='[!'){$url=$tmp;}}else{$required=count($brackets);}}elseif($name[0]==='?'){continue;}elseif(isset($params[$name])&&$params[$name]!=''){$required=count($brackets);$url=$params[$name].$url;unset($params[$name]);}elseif(isset($metadata[$name]['fixity'])){if($required===NULL&&!$brackets){$url='';}else{$url=$metadata[$name]['defOut'].$url;}}else{return
NULL;}}while(TRUE);if($this->type===self::RELATIVE){$url='//'.$refUrl->getAuthority().$refUrl->getBasePath().$url;}elseif($this->type===self::PATH){$url='//'.$refUrl->getAuthority().$url;}else{$host=array_reverse(explode('.',$refUrl->getHost()));$url=strtr($url,array('/%basePath%/'=>$refUrl->getBasePath(),'%tld%'=>$host[0],'%domain%'=>isset($host[1])?"$host[1].$host[0]":$host[0]));}if(strpos($url,'//',2)!==FALSE){return
NULL;}$url=($this->flags&self::SECURED?'https:':'http:').$url;if($this->xlat){$params=self::renameKeys($params,$this->xlat);}$sep=ini_get('arg_separator.input');$query=http_build_query($params,'',$sep?$sep[0]:'&');if($query!=''){$url.='?'.$query;}return$url;}private
function
setMask($mask,array$metadata){$this->mask=$mask;if(substr($mask,0,2)==='//'){$this->type=self::HOST;}elseif(substr($mask,0,1)==='/'){$this->type=self::PATH;}else{$this->type=self::RELATIVE;}foreach($metadata
as$name=>$meta){if(!is_array($meta)){$metadata[$name]=array(self::VALUE=>$meta,'fixity'=>self::CONSTANT);}elseif(array_key_exists(self::VALUE,$meta)){$metadata[$name]['fixity']=self::CONSTANT;}}$parts=Strings::split($mask,'/<([^>#= ]+)(=[^># ]*)? *([^>#]*)(#?[^>\[\]]*)>|(\[!?|\]|\s*\?.*)/');$this->xlat=array();$i=count($parts)-1;if(isset($parts[$i-1])&&substr(ltrim($parts[$i-1]),0,1)==='?'){$matches=Strings::matchAll($parts[$i-1],'/(?:([a-zA-Z0-9_.-]+)=)?<([^># ]+) *([^>#]*)(#?[^>]*)>/');foreach($matches
as$match){list(,$param,$name,$pattern,$class)=$match;if($class!==''){if(!isset(static::$styles[$class])){throw
new
Nette\InvalidStateException("Parameter '$name' has '$class' flag, but Route::\$styles['$class'] is not set.");}$meta=static::$styles[$class];}elseif(isset(static::$styles['?'.$name])){$meta=static::$styles['?'.$name];}else{$meta=static::$styles['?#'];}if(isset($metadata[$name])){$meta=$metadata[$name]+$meta;}if(array_key_exists(self::VALUE,$meta)){$meta['fixity']=self::OPTIONAL;}unset($meta['pattern']);$meta['filterTable2']=empty($meta[self::FILTER_TABLE])?NULL:array_flip($meta[self::FILTER_TABLE]);$metadata[$name]=$meta;if($param!==''){$this->xlat[$name]=$param;}}$i-=6;}$brackets=0;$re='';$sequence=array();$autoOptional=TRUE;do{array_unshift($sequence,$parts[$i]);$re=preg_quote($parts[$i],'#').$re;if($i===0){break;}$i--;$part=$parts[$i];if($part==='['||$part===']'||$part==='[!'){$brackets+=$part[0]==='['?-1:1;if($brackets<0){throw
new
Nette\InvalidArgumentException("Unexpected '$part' in mask '$mask'.");}array_unshift($sequence,$part);$re=($part[0]==='['?'(?:':')?').$re;$i-=5;continue;}$class=$parts[$i];$i--;$pattern=trim($parts[$i]);$i--;$default=$parts[$i];$i--;$name=$parts[$i];$i--;array_unshift($sequence,$name);if($name[0]==='?'){$name=substr($name,1);$re=$pattern?'(?:'.preg_quote($name,'#')."|$pattern)$re":preg_quote($name,'#').$re;$sequence[1]=$name.$sequence[1];continue;}if(preg_match('#[^a-z0-9_-]#i',$name)){throw
new
Nette\InvalidArgumentException("Parameter name must be alphanumeric string due to limitations of PCRE, '$name' given.");}if($class!==''){if(!isset(static::$styles[$class])){throw
new
Nette\InvalidStateException("Parameter '$name' has '$class' flag, but Route::\$styles['$class'] is not set.");}$meta=static::$styles[$class];}elseif(isset(static::$styles[$name])){$meta=static::$styles[$name];}else{$meta=static::$styles['#'];}if(isset($metadata[$name])){$meta=$metadata[$name]+$meta;}if($pattern==''&&isset($meta[self::PATTERN])){$pattern=$meta[self::PATTERN];}if($default!==''){$meta[self::VALUE]=(string)substr($default,1);$meta['fixity']=self::PATH_OPTIONAL;}$meta['filterTable2']=empty($meta[self::FILTER_TABLE])?NULL:array_flip($meta[self::FILTER_TABLE]);if(array_key_exists(self::VALUE,$meta)){if(isset($meta['filterTable2'][$meta[self::VALUE]])){$meta['defOut']=$meta['filterTable2'][$meta[self::VALUE]];}elseif(isset($meta[self::FILTER_OUT])){$meta['defOut']=call_user_func($meta[self::FILTER_OUT],$meta[self::VALUE]);}else{$meta['defOut']=$meta[self::VALUE];}}$meta[self::PATTERN]="#(?:$pattern)\\z#A".($this->flags&self::CASE_SENSITIVE?'':'iu');$re='(?P<'.str_replace('-','___',$name).'>(?U)'.$pattern.')'.$re;if($brackets){if(!isset($meta[self::VALUE])){$meta[self::VALUE]=$meta['defOut']=NULL;}$meta['fixity']=self::PATH_OPTIONAL;}elseif(!$autoOptional){unset($meta['fixity']);}elseif(isset($meta['fixity'])){$re='(?:'.$re.')?';$meta['fixity']=self::PATH_OPTIONAL;}else{$autoOptional=FALSE;}$metadata[$name]=$meta;}while(TRUE);if($brackets){throw
new
Nette\InvalidArgumentException("Missing closing ']' in mask '$mask'.");}$this->re='#'.$re.'/?\z#A'.($this->flags&self::CASE_SENSITIVE?'':'iu');$this->metadata=$metadata;$this->sequence=$sequence;}function
getMask(){return$this->mask;}function
getDefaults(){$defaults=array();foreach($this->metadata
as$name=>$meta){if(isset($meta['fixity'])){$defaults[$name]=$meta[self::VALUE];}}return$defaults;}function
getFlags(){return$this->flags;}function
getTargetPresenter(){if($this->flags&self::ONE_WAY){return
FALSE;}$m=$this->metadata;$module='';if(isset($m[self::MODULE_KEY])){if(isset($m[self::MODULE_KEY]['fixity'])&&$m[self::MODULE_KEY]['fixity']===self::CONSTANT){$module=$m[self::MODULE_KEY][self::VALUE].':';}else{return
NULL;}}if(isset($m[self::PRESENTER_KEY]['fixity'])&&$m[self::PRESENTER_KEY]['fixity']===self::CONSTANT){return$module.$m[self::PRESENTER_KEY][self::VALUE];}return
NULL;}private
static
function
renameKeys($arr,$xlat){if(empty($xlat)){return$arr;}$res=array();$occupied=array_flip($xlat);foreach($arr
as$k=>$v){if(isset($xlat[$k])){$res[$xlat[$k]]=$v;}elseif(!isset($occupied[$k])){$res[$k]=$v;}}return$res;}private
static
function
action2path($s){$s=preg_replace('#(.)(?=[A-Z])#','$1-',$s);$s=strtolower($s);$s=rawurlencode($s);return$s;}private
static
function
path2action($s){$s=strtolower($s);$s=preg_replace('#-(?=[a-z])#',' ',$s);$s=substr(ucwords('x'.$s),1);$s=str_replace(' ','',$s);return$s;}private
static
function
presenter2path($s){$s=strtr($s,':','.');$s=preg_replace('#([^.])(?=[A-Z])#','$1-',$s);$s=strtolower($s);$s=rawurlencode($s);return$s;}private
static
function
path2presenter($s){$s=strtolower($s);$s=preg_replace('#([.-])(?=[a-z])#','$1 ',$s);$s=ucwords($s);$s=str_replace('. ',':',$s);$s=str_replace('- ','',$s);return$s;}private
static
function
param2path($s){return
str_replace('%2F','/',rawurlencode($s));}static
function
addStyle($style,$parent='#'){if(isset(static::$styles[$style])){throw
new
Nette\InvalidArgumentException("Style '$style' already exists.");}if($parent!==NULL){if(!isset(static::$styles[$parent])){throw
new
Nette\InvalidArgumentException("Parent style '$parent' doesn't exist.");}static::$styles[$style]=static::$styles[$parent];}else{static::$styles[$style]=array();}}static
function
setStyleProperty($style,$key,$value){if(!isset(static::$styles[$style])){throw
new
Nette\InvalidArgumentException("Style '$style' doesn't exist.");}static::$styles[$style][$key]=$value;}}}namespace Nette{use
Nette;class
ArrayList
extends
Object
implements\ArrayAccess,\Countable,\IteratorAggregate{private$list=array();function
getIterator(){return
new\ArrayIterator($this->list);}function
count(){return
count($this->list);}function
offsetSet($index,$value){if($index===NULL){$this->list[]=$value;}elseif($index<0||$index>=count($this->list)){throw
new
OutOfRangeException("Offset invalid or out of range");}else{$this->list[(int)$index]=$value;}}function
offsetGet($index){if($index<0||$index>=count($this->list)){throw
new
OutOfRangeException("Offset invalid or out of range");}return$this->list[(int)$index];}function
offsetExists($index){return$index>=0&&$index<count($this->list);}function
offsetUnset($index){if($index<0||$index>=count($this->list)){throw
new
OutOfRangeException("Offset invalid or out of range");}array_splice($this->list,(int)$index,1);}}}namespace Nette\Application\Routers{use
Nette;class
RouteList
extends
Nette\ArrayList
implements
Nette\Application\IRouter{private$cachedRoutes;private$module;function
__construct($module=NULL){$this->module=$module?$module.':':'';}function
match(Nette\Http\IRequest$httpRequest){foreach($this
as$route){$appRequest=$route->match($httpRequest);if($appRequest!==NULL){$appRequest->setPresenterName($this->module.$appRequest->getPresenterName());return$appRequest;}}return
NULL;}function
constructUrl(Nette\Application\Request$appRequest,Nette\Http\Url$refUrl){if($this->cachedRoutes===NULL){$routes=array();$routes['*']=array();foreach($this
as$route){$presenter=$route
instanceof
Route?$route->getTargetPresenter():NULL;if($presenter===FALSE){continue;}if(is_string($presenter)){$presenter=strtolower($presenter);if(!isset($routes[$presenter])){$routes[$presenter]=$routes['*'];}$routes[$presenter][]=$route;}else{foreach($routes
as$id=>$foo){$routes[$id][]=$route;}}}$this->cachedRoutes=$routes;}if($this->module){if(strncasecmp($tmp=$appRequest->getPresenterName(),$this->module,strlen($this->module))===0){$appRequest=clone$appRequest;$appRequest->setPresenterName(substr($tmp,strlen($this->module)));}else{return
NULL;}}$presenter=strtolower($appRequest->getPresenterName());if(!isset($this->cachedRoutes[$presenter])){$presenter='*';}foreach($this->cachedRoutes[$presenter]as$route){$url=$route->constructUrl($appRequest,$refUrl);if($url!==NULL){return$url;}}return
NULL;}function
offsetSet($index,$route){if(!$route
instanceof
Nette\Application\IRouter){throw
new
Nette\InvalidArgumentException("Argument must be IRouter descendant.");}parent::offsetSet($index,$route);}function
getModule(){return$this->module;}}use
Nette\Application;class
SimpleRouter
extends
Nette\Object
implements
Application\IRouter{const
PRESENTER_KEY='presenter';const
MODULE_KEY='module';private$module='';private$defaults;private$flags;function
__construct($defaults=array(),$flags=0){if(is_string($defaults)){$a=strrpos($defaults,':');if(!$a){throw
new
Nette\InvalidArgumentException("Argument must be array or string in format Presenter:action, '$defaults' given.");}$defaults=array(self::PRESENTER_KEY=>substr($defaults,0,$a),'action'=>$a===strlen($defaults)-1?Application\UI\Presenter::DEFAULT_ACTION:substr($defaults,$a+1));}if(isset($defaults[self::MODULE_KEY])){$this->module=$defaults[self::MODULE_KEY].':';unset($defaults[self::MODULE_KEY]);}$this->defaults=$defaults;$this->flags=$flags;}function
match(Nette\Http\IRequest$httpRequest){if($httpRequest->getUrl()->getPathInfo()!==''){return
NULL;}$params=$httpRequest->getQuery();$params+=$this->defaults;if(!isset($params[self::PRESENTER_KEY])||!is_string($params[self::PRESENTER_KEY])){return
NULL;}$presenter=$this->module.$params[self::PRESENTER_KEY];unset($params[self::PRESENTER_KEY]);return
new
Application\Request($presenter,$httpRequest->getMethod(),$params,$httpRequest->getPost(),$httpRequest->getFiles(),array(Application\Request::SECURED=>$httpRequest->isSecured()));}function
constructUrl(Application\Request$appRequest,Nette\Http\Url$refUrl){if($this->flags&self::ONE_WAY){return
NULL;}$params=$appRequest->getParameters();$presenter=$appRequest->getPresenterName();if(strncasecmp($presenter,$this->module,strlen($this->module))===0){$params[self::PRESENTER_KEY]=substr($presenter,strlen($this->module));}else{return
NULL;}foreach($this->defaults
as$key=>$value){if(isset($params[$key])&&$params[$key]==$value){unset($params[$key]);}}$url=($this->flags&self::SECURED?'https://':'http://').$refUrl->getAuthority().$refUrl->getPath();$sep=ini_get('arg_separator.input');$query=http_build_query($params,'',$sep?$sep[0]:'&');if($query!=''){$url.='?'.$query;}return$url;}function
getDefaults(){return$this->defaults;}function
getFlags(){return$this->flags;}}}namespace Nette\Application\UI{use
Nette;class
BadSignalException
extends
Nette\Application\BadRequestException{protected$defaultCode=403;}}namespace Nette\ComponentModel{use
Nette;abstract
class
Component
extends
Nette\Object
implements
IComponent{private$parent;private$name;private$monitors=array();function
__construct(IContainer$parent=NULL,$name=NULL){if($parent!==NULL){$parent->addComponent($this,$name);}elseif(is_string($name)){$this->name=$name;}}function
lookup($type,$need=TRUE){if(!isset($this->monitors[$type])){$obj=$this->parent;$path=self::NAME_SEPARATOR.$this->name;$depth=1;while($obj!==NULL){$parent=$obj->getParent();if($type?$obj
instanceof$type:$parent===NULL){break;}$path=self::NAME_SEPARATOR.$obj->getName().$path;$depth++;$obj=$parent;if($obj===$this){$obj=NULL;}}if($obj){$this->monitors[$type]=array($obj,$depth,substr($path,1),FALSE);}else{$this->monitors[$type]=array(NULL,NULL,NULL,FALSE);}}if($need&&$this->monitors[$type][0]===NULL){throw
new
Nette\InvalidStateException("Component '$this->name' is not attached to '$type'.");}return$this->monitors[$type][0];}function
lookupPath($type,$need=TRUE){$this->lookup($type,$need);return$this->monitors[$type][2];}function
monitor($type){if(empty($this->monitors[$type][3])){if($obj=$this->lookup($type,FALSE)){$this->attached($obj);}$this->monitors[$type][3]=TRUE;}}function
unmonitor($type){unset($this->monitors[$type]);}protected
function
attached($obj){}protected
function
detached($obj){}final
function
getName(){return$this->name;}final
function
getParent(){return$this->parent;}function
setParent(IContainer$parent=NULL,$name=NULL){if($parent===NULL&&$this->parent===NULL&&$name!==NULL){$this->name=$name;return$this;}elseif($parent===$this->parent&&$name===NULL){return$this;}if($this->parent!==NULL&&$parent!==NULL){throw
new
Nette\InvalidStateException("Component '$this->name' already has a parent.");}if($parent===NULL){$this->refreshMonitors(0);$this->parent=NULL;}else{$this->validateParent($parent);$this->parent=$parent;if($name!==NULL){$this->name=$name;}$tmp=array();$this->refreshMonitors(0,$tmp);}return$this;}protected
function
validateParent(IContainer$parent){}private
function
refreshMonitors($depth,&$missing=NULL,&$listeners=array()){if($this
instanceof
IContainer){foreach($this->getComponents()as$component){if($component
instanceof
Component){$component->refreshMonitors($depth+1,$missing,$listeners);}}}if($missing===NULL){foreach($this->monitors
as$type=>$rec){if(isset($rec[1])&&$rec[1]>$depth){if($rec[3]){$this->monitors[$type]=array(NULL,NULL,NULL,TRUE);$listeners[]=array($this,$rec[0]);}else{unset($this->monitors[$type]);}}}}else{foreach($this->monitors
as$type=>$rec){if(isset($rec[0])){continue;}elseif(!$rec[3]){unset($this->monitors[$type]);}elseif(isset($missing[$type])){$this->monitors[$type]=array(NULL,NULL,NULL,TRUE);}else{$this->monitors[$type]=NULL;if($obj=$this->lookup($type,FALSE)){$listeners[]=array($this,$obj);}else{$missing[$type]=TRUE;}$this->monitors[$type][3]=TRUE;}}}if($depth===0){$method=$missing===NULL?'detached':'attached';foreach($listeners
as$item){$item[0]->$method($item[1]);}}}function
__clone(){if($this->parent===NULL){return;}elseif($this->parent
instanceof
Container){$this->parent=$this->parent->_isCloning();if($this->parent===NULL){$this->refreshMonitors(0);}}else{$this->parent=NULL;$this->refreshMonitors(0);}}final
function
__sleep(){throw
new
Nette\NotImplementedException('Object serialization is not supported by class '.get_class($this));}final
function
__wakeup(){throw
new
Nette\NotImplementedException('Object unserialization is not supported by class '.get_class($this));}}class
Container
extends
Component
implements
IContainer{private$components=array();private$cloning;function
addComponent(IComponent$component,$name,$insertBefore=NULL){if($name===NULL){$name=$component->getName();}if(is_int($name)){$name=(string)$name;}elseif(!is_string($name)){throw
new
Nette\InvalidArgumentException("Component name must be integer or string, ".gettype($name)." given.");}elseif(!preg_match('#^[a-zA-Z0-9_]+\z#',$name)){throw
new
Nette\InvalidArgumentException("Component name must be non-empty alphanumeric string, '$name' given.");}if(isset($this->components[$name])){throw
new
Nette\InvalidStateException("Component with name '$name' already exists.");}$obj=$this;do{if($obj===$component){throw
new
Nette\InvalidStateException("Circular reference detected while adding component '$name'.");}$obj=$obj->getParent();}while($obj!==NULL);$this->validateChildComponent($component);try{if(isset($this->components[$insertBefore])){$tmp=array();foreach($this->components
as$k=>$v){if($k===$insertBefore){$tmp[$name]=$component;}$tmp[$k]=$v;}$this->components=$tmp;}else{$this->components[$name]=$component;}$component->setParent($this,$name);}catch(\Exception$e){unset($this->components[$name]);throw$e;}return$this;}function
removeComponent(IComponent$component){$name=$component->getName();if(!isset($this->components[$name])||$this->components[$name]!==$component){throw
new
Nette\InvalidArgumentException("Component named '$name' is not located in this container.");}unset($this->components[$name]);$component->setParent(NULL);}final
function
getComponent($name,$need=TRUE){if(is_int($name)){$name=(string)$name;}elseif(!is_string($name)){throw
new
Nette\InvalidArgumentException("Component name must be integer or string, ".gettype($name)." given.");}else{$a=strpos($name,self::NAME_SEPARATOR);if($a!==FALSE){$ext=(string)substr($name,$a+1);$name=substr($name,0,$a);}if($name===''){if($need){throw
new
Nette\InvalidArgumentException("Component or subcomponent name must not be empty string.");}return;}}if(!isset($this->components[$name])){$component=$this->createComponent($name);if($component
instanceof
IComponent&&$component->getParent()===NULL){$this->addComponent($component,$name);}}if(isset($this->components[$name])){if(!isset($ext)){return$this->components[$name];}elseif($this->components[$name]instanceof
IContainer){return$this->components[$name]->getComponent($ext,$need);}elseif($need){throw
new
Nette\InvalidArgumentException("Component with name '$name' is not container and cannot have '$ext' component.");}}elseif($need){throw
new
Nette\InvalidArgumentException("Component with name '$name' does not exist.");}}protected
function
createComponent($name){$ucname=ucfirst($name);$method='createComponent'.$ucname;if($ucname!==$name&&method_exists($this,$method)&&$this->getReflection()->getMethod($method)->getName()===$method){$component=$this->$method($name);if(!$component
instanceof
IComponent&&!isset($this->components[$name])){$class=get_class($this);throw
new
Nette\UnexpectedValueException("Method $class::$method() did not return or create the desired component.");}return$component;}}final
function
getComponents($deep=FALSE,$filterType=NULL){$iterator=new
RecursiveComponentIterator($this->components);if($deep){$deep=$deep>0?\RecursiveIteratorIterator::SELF_FIRST:\RecursiveIteratorIterator::CHILD_FIRST;$iterator=new\RecursiveIteratorIterator($iterator,$deep);}if($filterType){$iterator=new
Nette\Iterators\Filter($iterator,function($item)use($filterType){return$item
instanceof$filterType;});}return$iterator;}protected
function
validateChildComponent(IComponent$child){}function
__clone(){if($this->components){$oldMyself=reset($this->components)->getParent();$oldMyself->cloning=$this;foreach($this->components
as$name=>$component){$this->components[$name]=clone$component;}$oldMyself->cloning=NULL;}parent::__clone();}function
_isCloning(){return$this->cloning;}}}namespace Nette\Application\UI{use
Nette;abstract
class
PresenterComponent
extends
Nette\ComponentModel\Container
implements
ISignalReceiver,IStatePersistent,\ArrayAccess{protected$params=array();function
getPresenter($need=TRUE){return$this->lookup('Nette\Application\UI\Presenter',$need);}function
getUniqueId(){return$this->lookupPath('Nette\Application\UI\Presenter',TRUE);}protected
function
attached($presenter){if($presenter
instanceof
Presenter){$this->loadState($presenter->popGlobalParameters($this->getUniqueId()));}}protected
function
validateParent(Nette\ComponentModel\IContainer$parent){parent::validateParent($parent);$this->monitor('Nette\Application\UI\Presenter');}protected
function
tryCall($method,array$params){$rc=$this->getReflection();if($rc->hasMethod($method)){$rm=$rc->getMethod($method);if($rm->isPublic()&&!$rm->isAbstract()&&!$rm->isStatic()){$this->checkRequirements($rm);$rm->invokeArgs($this,$rc->combineArgs($rm,$params));return
TRUE;}}return
FALSE;}function
checkRequirements($element){}static
function
getReflection(){return
new
PresenterComponentReflection(get_called_class());}function
loadState(array$params){$reflection=$this->getReflection();foreach($reflection->getPersistentParams()as$name=>$meta){if(isset($params[$name])){$type=gettype($meta['def']);if(!$reflection->convertType($params[$name],$type)){throw
new
Nette\Application\BadRequestException("Invalid value for persistent parameter '$name' in '{$this->getName()}', expected ".($type==='NULL'?'scalar':$type).".");}$this->$name=$params[$name];}else{$params[$name]=$this->$name;}}$this->params=$params;}function
saveState(array&$params,$reflection=NULL){$reflection=$reflection===NULL?$this->getReflection():$reflection;foreach($reflection->getPersistentParams()as$name=>$meta){if(isset($params[$name])){}elseif(array_key_exists($name,$params)){continue;}elseif(!isset($meta['since'])||$this
instanceof$meta['since']){$params[$name]=$this->$name;}else{continue;}$type=gettype($meta['def']);if(!PresenterComponentReflection::convertType($params[$name],$type)){throw
new
InvalidLinkException("Invalid value for persistent parameter '$name' in '{$this->getName()}', expected ".($type==='NULL'?'scalar':$type).".");}if($params[$name]===$meta['def']||($meta['def']===NULL&&is_scalar($params[$name])&&(string)$params[$name]==='')){$params[$name]=NULL;}}}final
function
getParameter($name=NULL,$default=NULL){if(func_num_args()===0){trigger_error('Calling '.__METHOD__.' with no arguments to get all parameters is deprecated, use getParameters() instead.',E_USER_DEPRECATED);return$this->params;}elseif(isset($this->params[$name])){return$this->params[$name];}else{return$default;}}final
function
getParameters(){return$this->params;}final
function
getParameterId($name){$uid=$this->getUniqueId();return$uid===''?$name:$uid.self::NAME_SEPARATOR.$name;}function
getParam($name=NULL,$default=NULL){return
func_num_args()?$this->getParameter($name,$default):$this->getParameter();}static
function
getPersistentParams(){$rc=new
Nette\Reflection\ClassType(get_called_class());$params=array();foreach($rc->getProperties(\ReflectionProperty::IS_PUBLIC)as$rp){if(!$rp->isStatic()&&$rp->hasAnnotation('persistent')){$params[]=$rp->getName();}}return$params;}function
signalReceived($signal){if(!$this->tryCall($this->formatSignalMethod($signal),$this->params)){$class=get_class($this);throw
new
BadSignalException("There is no handler for signal '$signal' in class $class.");}}static
function
formatSignalMethod($signal){return$signal==NULL?NULL:'handle'.$signal;}function
link($destination,$args=array()){try{return$this->getPresenter()->createRequest($this,$destination,is_array($args)?$args:array_slice(func_get_args(),1),'link');}catch(InvalidLinkException$e){return$this->getPresenter()->handleInvalidLink($e);}}function
lazyLink($destination,$args=array()){return
new
Link($this,$destination,is_array($args)?$args:array_slice(func_get_args(),1));}function
isLinkCurrent($destination=NULL,$args=array()){if($destination!==NULL){$this->getPresenter()->createRequest($this,$destination,is_array($args)?$args:array_slice(func_get_args(),1),'test');}return$this->getPresenter()->getLastCreatedRequestFlag('current');}function
redirect($code,$destination=NULL,$args=array()){if(!is_numeric($code)){$args=$destination;$destination=$code;$code=NULL;}if(!is_array($args)){$args=array_slice(func_get_args(),is_numeric($code)?2:1);}$presenter=$this->getPresenter();$presenter->redirectUrl($presenter->createRequest($this,$destination,$args,'redirect'),$code);}final
function
offsetSet($name,$component){$this->addComponent($component,$name);}final
function
offsetGet($name){return$this->getComponent($name,TRUE);}final
function
offsetExists($name){return$this->getComponent($name,FALSE)!==NULL;}final
function
offsetUnset($name){$component=$this->getComponent($name,FALSE);if($component!==NULL){$this->removeComponent($component);}}}abstract
class
Control
extends
PresenterComponent
implements
IRenderable{private$template;private$invalidSnippets=array();public$snippetMode;final
function
getTemplate(){if($this->template===NULL){$value=$this->createTemplate();if(!$value
instanceof
Nette\Templating\ITemplate&&$value!==NULL){$class2=get_class($value);$class=get_class($this);throw
new
Nette\UnexpectedValueException("Object returned by $class::createTemplate() must be instance of Nette\\Templating\\ITemplate, '$class2' given.");}$this->template=$value;}return$this->template;}protected
function
createTemplate($class=NULL){$template=$class?new$class:new
Nette\Templating\FileTemplate;$presenter=$this->getPresenter(FALSE);$template->onPrepareFilters[]=$this->templatePrepareFilters;$template->registerHelperLoader('Nette\Templating\Helpers::loader');$template->control=$template->_control=$this;$template->presenter=$template->_presenter=$presenter;if($presenter
instanceof
Presenter){$template->setCacheStorage($presenter->getContext()->getService('nette.templateCacheStorage'));$template->user=$presenter->getUser();$template->netteHttpResponse=$presenter->getHttpResponse();$template->netteCacheStorage=$presenter->getContext()->getByType('Nette\Caching\IStorage');$template->baseUri=$template->baseUrl=rtrim($presenter->getHttpRequest()->getUrl()->getBaseUrl(),'/');$template->basePath=preg_replace('#https?://[^/]+#A','',$template->baseUrl);if($presenter->hasFlashSession()){$id=$this->getParameterId('flash');$template->flashes=$presenter->getFlashSession()->$id;}}if(!isset($template->flashes)||!is_array($template->flashes)){$template->flashes=array();}return$template;}function
templatePrepareFilters($template){$template->registerFilter($this->getPresenter()->getContext()->createService('nette.latte'));}function
flashMessage($message,$type='info'){$id=$this->getParameterId('flash');$messages=$this->getPresenter()->getFlashSession()->$id;$messages[]=$flash=(object)array('message'=>$message,'type'=>$type);$this->getTemplate()->flashes=$messages;$this->getPresenter()->getFlashSession()->$id=$messages;return$flash;}function
invalidateControl($snippet=NULL){$this->invalidSnippets[$snippet]=TRUE;}function
validateControl($snippet=NULL){if($snippet===NULL){$this->invalidSnippets=array();}else{unset($this->invalidSnippets[$snippet]);}}function
isControlInvalid($snippet=NULL){if($snippet===NULL){if(count($this->invalidSnippets)>0){return
TRUE;}else{$queue=array($this);do{foreach(array_shift($queue)->getComponents()as$component){if($component
instanceof
IRenderable){if($component->isControlInvalid()){return
TRUE;}}elseif($component
instanceof
Nette\ComponentModel\IContainer){$queue[]=$component;}}}while($queue);return
FALSE;}}else{return
isset($this->invalidSnippets[NULL])||isset($this->invalidSnippets[$snippet]);}}function
getSnippetId($name=NULL){return'snippet-'.$this->getUniqueId().'-'.$name;}}}namespace Nette\Forms{use
Nette;class
Container
extends
Nette\ComponentModel\Container
implements\ArrayAccess{public$onValidate;protected$currentGroup;private$validated;function
setDefaults($values,$erase=FALSE){$form=$this->getForm(FALSE);if(!$form||!$form->isAnchored()||!$form->isSubmitted()){$this->setValues($values,$erase);}return$this;}function
setValues($values,$erase=FALSE){if($values
instanceof\Traversable){$values=iterator_to_array($values);}elseif(!is_array($values)){throw
new
Nette\InvalidArgumentException('First parameter must be an array, '.gettype($values).' given.');}foreach($this->getComponents()as$name=>$control){if($control
instanceof
IControl){if(array_key_exists($name,$values)){$control->setValue($values[$name]);}elseif($erase){$control->setValue(NULL);}}elseif($control
instanceof
Container){if(array_key_exists($name,$values)){$control->setValues($values[$name],$erase);}elseif($erase){$control->setValues(array(),$erase);}}}return$this;}function
getValues($asArray=FALSE){$values=$asArray?array():new
Nette\ArrayHash;foreach($this->getComponents()as$name=>$control){if($control
instanceof
IControl&&!$control->isOmitted()){$values[$name]=$control->getValue();}elseif($control
instanceof
Container){$values[$name]=$control->getValues($asArray);}}return$values;}function
isValid(){if(!$this->validated){$this->validate();}return!$this->getAllErrors();}function
validate(array$controls=NULL){foreach($controls===NULL?$this->getControls():$controls
as$control){$control->validate();}$this->onValidate($this);$this->validated=TRUE;}function
getAllErrors(){$errors=array();foreach($this->getControls()as$control){$errors=array_merge($errors,$control->getErrors());}return
array_unique($errors);}function
setCurrentGroup(ControlGroup$group=NULL){$this->currentGroup=$group;return$this;}function
getCurrentGroup(){return$this->currentGroup;}function
addComponent(Nette\ComponentModel\IComponent$component,$name,$insertBefore=NULL){parent::addComponent($component,$name,$insertBefore);if($this->currentGroup!==NULL&&$component
instanceof
IControl){$this->currentGroup->add($component);}return$this;}function
getControls(){return$this->getComponents(TRUE,'Nette\Forms\IControl');}function
getForm($need=TRUE){return$this->lookup('Nette\Forms\Form',$need);}function
addText($name,$label=NULL,$cols=NULL,$maxLength=NULL){$control=new
Controls\TextInput($label,$maxLength);if($cols){trigger_error(__METHOD__.'() third parameter $cols is deprecated.',E_USER_DEPRECATED);$control->getControlPrototype()->size($cols);}return$this[$name]=$control;}function
addPassword($name,$label=NULL,$cols=NULL,$maxLength=NULL){$control=new
Controls\TextInput($label,$maxLength);if($cols){trigger_error(__METHOD__.'() third parameter $cols is deprecated.',E_USER_DEPRECATED);$control->getControlPrototype()->size($cols);}return$this[$name]=$control->setType('password');}function
addTextArea($name,$label=NULL,$cols=NULL,$rows=NULL){$control=new
Controls\TextArea($label);if($cols||$rows){trigger_error(__METHOD__.'() parameters $cols and $rows are deprecated.',E_USER_DEPRECATED);$control->getControlPrototype()->cols($cols)->rows($rows);}return$this[$name]=$control;}function
addUpload($name,$label=NULL,$multiple=FALSE){return$this[$name]=new
Controls\UploadControl($label,$multiple);}function
addHidden($name,$default=NULL){$control=new
Controls\HiddenField;$control->setDefaultValue($default);return$this[$name]=$control;}function
addCheckbox($name,$caption=NULL){return$this[$name]=new
Controls\Checkbox($caption);}function
addRadioList($name,$label=NULL,array$items=NULL){return$this[$name]=new
Controls\RadioList($label,$items);}function
addSelect($name,$label=NULL,array$items=NULL,$size=NULL){return$this[$name]=new
Controls\SelectBox($label,$items,$size);}function
addMultiSelect($name,$label=NULL,array$items=NULL,$size=NULL){return$this[$name]=new
Controls\MultiSelectBox($label,$items,$size);}function
addSubmit($name,$caption=NULL){return$this[$name]=new
Controls\SubmitButton($caption);}function
addButton($name,$caption=NULL){return$this[$name]=new
Controls\Button($caption);}function
addImage($name,$src=NULL,$alt=NULL){return$this[$name]=new
Controls\ImageButton($src,$alt);}function
addContainer($name){$control=new
Container;$control->currentGroup=$this->currentGroup;return$this[$name]=$control;}final
function
offsetSet($name,$component){$this->addComponent($component,$name);}final
function
offsetGet($name){return$this->getComponent($name,TRUE);}final
function
offsetExists($name){return$this->getComponent($name,FALSE)!==NULL;}final
function
offsetUnset($name){$component=$this->getComponent($name,FALSE);if($component!==NULL){$this->removeComponent($component);}}final
function
__clone(){throw
new
Nette\NotImplementedException('Form cloning is not supported yet.');}}class
Form
extends
Container{const
EQUAL=':equal',IS_IN=self::EQUAL,FILLED=':filled',REQUIRED=self::FILLED,VALID=':valid';const
PROTECTION=Controls\CsrfProtection::PROTECTION;const
SUBMITTED=':submitted';const
MIN_LENGTH=':minLength',MAX_LENGTH=':maxLength',LENGTH=':length',EMAIL=':email',URL=':url',REGEXP=':regexp',PATTERN=':pattern',INTEGER=':integer',NUMERIC=':integer',FLOAT=':float',RANGE=':range';const
COUNT=self::LENGTH;const
MAX_FILE_SIZE=':fileSize',MIME_TYPE=':mimeType',IMAGE=':image';const
GET='get',POST='post';const
DATA_TEXT=1;const
DATA_LINE=2;const
DATA_FILE=3;const
TRACKER_ID='_form_';const
PROTECTOR_ID='_token_';public$onSuccess;public$onError;public$onSubmit;private$submittedBy;private$httpData;private$element;private$renderer;private$translator;private$groups=array();private$errors=array();public$httpRequest;function
__construct($name=NULL){$this->element=Nette\Utils\Html::el('form');$this->element->action='';$this->element->method=self::POST;$this->element->id=$name===NULL?NULL:'frm-'.$name;$this->monitor(__CLASS__);if($name!==NULL){$tracker=new
Controls\HiddenField;$tracker->setValue($name)->setOmitted()->unmonitor(__CLASS__);$this[self::TRACKER_ID]=$tracker;}parent::__construct(NULL,$name);}protected
function
attached($obj){if($obj
instanceof
self){throw
new
Nette\InvalidStateException('Nested forms are forbidden.');}}final
function
getForm($need=TRUE){return$this;}function
setAction($url){$this->element->action=$url;return$this;}function
getAction(){return$this->element->action;}function
setMethod($method){if($this->httpData!==NULL){throw
new
Nette\InvalidStateException(__METHOD__.'() must be called until the form is empty.');}$this->element->method=strtolower($method);return$this;}function
getMethod(){return$this->element->method;}function
addProtection($message=NULL){return$this[self::PROTECTOR_ID]=new
Controls\CsrfProtection($message);}function
addGroup($caption=NULL,$setAsCurrent=TRUE){$group=new
ControlGroup;$group->setOption('label',$caption);$group->setOption('visual',TRUE);if($setAsCurrent){$this->setCurrentGroup($group);}if(!is_scalar($caption)||isset($this->groups[$caption])){return$this->groups[]=$group;}else{return$this->groups[$caption]=$group;}}function
removeGroup($name){if(is_string($name)&&isset($this->groups[$name])){$group=$this->groups[$name];}elseif($name
instanceof
ControlGroup&&in_array($name,$this->groups,TRUE)){$group=$name;$name=array_search($group,$this->groups,TRUE);}else{throw
new
Nette\InvalidArgumentException("Group not found in form '$this->name'");}foreach($group->getControls()as$control){$control->getParent()->removeComponent($control);}unset($this->groups[$name]);}function
getGroups(){return$this->groups;}function
getGroup($name){return
isset($this->groups[$name])?$this->groups[$name]:NULL;}function
setTranslator(Nette\Localization\ITranslator$translator=NULL){$this->translator=$translator;return$this;}final
function
getTranslator(){return$this->translator;}function
isAnchored(){return
TRUE;}final
function
isSubmitted(){if($this->submittedBy===NULL){$this->getHttpData();}return$this->submittedBy;}final
function
isSuccess(){return$this->isSubmitted()&&$this->isValid();}function
setSubmittedBy(ISubmitterControl$by=NULL){$this->submittedBy=$by===NULL?FALSE:$by;return$this;}final
function
getHttpData($htmlName=NULL,$type=self::DATA_TEXT){if($this->httpData===NULL){if(!$this->isAnchored()){throw
new
Nette\InvalidStateException('Form is not anchored and therefore can not determine whether it was submitted.');}$data=$this->receiveHttpData();$this->httpData=(array)$data;$this->submittedBy=is_array($data);}if($htmlName===NULL){return$this->httpData;}return
Helpers::extractHttpData($this->httpData,$htmlName,$type);}function
fireEvents(){if(!$this->isSubmitted()){return;}elseif($this->submittedBy
instanceof
ISubmitterControl){if($this->isValid()){$this->submittedBy->onClick($this->submittedBy);}else{$this->submittedBy->onInvalidClick($this->submittedBy);}}if($this->isValid()){$this->onSuccess($this);}else{$this->onError($this);}$this->onSubmit($this);}protected
function
receiveHttpData(){$httpRequest=$this->getHttpRequest();if(strcasecmp($this->getMethod(),$httpRequest->getMethod())){return;}if($httpRequest->isMethod('post')){$data=Nette\Utils\Arrays::mergeTree($httpRequest->getPost(),$httpRequest->getFiles());}else{$data=$httpRequest->getQuery();if(!$data){return;}}if($tracker=$this->getComponent(self::TRACKER_ID,FALSE)){if(!isset($data[self::TRACKER_ID])||$data[self::TRACKER_ID]!==$tracker->getValue()){return;}}return$data;}function
validate(array$controls=NULL){if($controls===NULL&&$this->submittedBy
instanceof
ISubmitterControl){$controls=$this->submittedBy->getValidationScope();}parent::validate($controls);}function
addError($message){$this->errors[]=$message;}function
getErrors(){return
array_unique($this->errors);}function
hasErrors(){return(bool)$this->getErrors();}function
cleanErrors(){$this->errors=array();}function
getAllErrors(){return
array_unique(array_merge($this->errors,parent::getAllErrors()));}function
getElementPrototype(){return$this->element;}function
setRenderer(IFormRenderer$renderer){$this->renderer=$renderer;return$this;}final
function
getRenderer(){if($this->renderer===NULL){$this->renderer=new
Rendering\DefaultFormRenderer;}return$this->renderer;}function
render(){$args=func_get_args();array_unshift($args,$this);echo
call_user_func_array(array($this->getRenderer(),'render'),$args);}function
__toString(){try{return$this->getRenderer()->render($this);}catch(\Exception$e){if(func_get_args()&&func_get_arg(0)){throw$e;}else{trigger_error("Exception in ".__METHOD__."(): {$e->getMessage()} in {$e->getFile()}:{$e->getLine()}",E_USER_ERROR);}}}private
function
getHttpRequest(){if(!$this->httpRequest){$factory=new
Nette\Http\RequestFactory;$this->httpRequest=$factory->createHttpRequest();}return$this->httpRequest;}function
getToggles(){$toggles=array();foreach($this->getControls()as$control){foreach($control->getRules()->getToggles(TRUE)as$id=>$hide){$toggles[$id]=empty($toggles[$id])?$hide:TRUE;}}return$toggles;}}}namespace Nette\Application\UI{use
Nette;class
Form
extends
Nette\Forms\Form
implements
ISignalReceiver{function
__construct(Nette\ComponentModel\IContainer$parent=NULL,$name=NULL){parent::__construct();$this->monitor('Nette\Application\UI\Presenter');if($parent!==NULL){$parent->addComponent($this,$name);}}function
getPresenter($need=TRUE){return$this->lookup('Nette\Application\UI\Presenter',$need);}protected
function
attached($presenter){if($presenter
instanceof
Presenter){$name=$this->lookupPath('Nette\Application\UI\Presenter');if(!isset($this->getElementPrototype()->id)){$this->getElementPrototype()->id='frm-'.$name;}if(!$this->getAction()){$this->setAction(new
Link($presenter,'this',array()));}if(iterator_count($this->getControls())&&$this->isSubmitted()){foreach($this->getControls()as$control){if(!$control->isDisabled()){$control->loadHttpData();}}}$signal=new
Nette\Forms\Controls\HiddenField;$signal->setValue($name.self::NAME_SEPARATOR.'submit')->setOmitted()->setHtmlId(FALSE)->unmonitor('Nette\Forms\Form');$this[Presenter::SIGNAL_KEY]=$signal;}parent::attached($presenter);}function
isAnchored(){return(bool)$this->getPresenter(FALSE);}protected
function
receiveHttpData(){$presenter=$this->getPresenter();if(!$presenter->isSignalReceiver($this,'submit')){return;}$isPost=$this->getMethod()===self::POST;$request=$presenter->getRequest();if($request->isMethod('forward')||$request->isMethod('post')!==$isPost){return;}if($isPost){return
Nette\Utils\Arrays::mergeTree($request->getPost(),$request->getFiles());}else{return$request->getParameters();}}function
signalReceived($signal){if($signal==='submit'){if(!$this->getPresenter()->getRequest()->hasFlag(Nette\Application\Request::RESTORED)){$this->fireEvents();}}else{$class=get_class($this);throw
new
BadSignalException("Missing handler for signal '$signal' in $class.");}}}class
InvalidLinkException
extends\Exception{}class
Link
extends
Nette\Object{private$component;private$destination;private$params;function
__construct(PresenterComponent$component,$destination,array$params){$this->component=$component;$this->destination=$destination;$this->params=$params;}function
getDestination(){return$this->destination;}function
setParameter($key,$value){$this->params[$key]=$value;return$this;}function
getParameter($key){return
isset($this->params[$key])?$this->params[$key]:NULL;}function
getParameters(){return$this->params;}function
__toString(){try{return(string)$this->component->link($this->destination,$this->params);}catch(\Exception$e){trigger_error("Exception in ".__METHOD__."(): {$e->getMessage()} in {$e->getFile()}:{$e->getLine()}",E_USER_ERROR);}}}class
Multiplier
extends
PresenterComponent{private$factory;function
__construct($factory){parent::__construct();$this->factory=Nette\Utils\Callback::check($factory);}protected
function
createComponent($name){return
call_user_func($this->factory,$name,$this);}}use
Nette\Application;use
Nette\Application\Responses;use
Nette\Http;use
Nette\Reflection;abstract
class
Presenter
extends
Control
implements
Application\IPresenter{const
INVALID_LINK_SILENT=1,INVALID_LINK_WARNING=2,INVALID_LINK_EXCEPTION=3;const
SIGNAL_KEY='do',ACTION_KEY='action',FLASH_KEY='_fid',DEFAULT_ACTION='default';public$invalidLinkMode;public$onShutdown;private$request;private$response;public$autoCanonicalize=TRUE;public$absoluteUrls=FALSE;private$globalParams;private$globalState;private$globalStateSinces;private$action;private$view;private$layout;private$payload;private$signalReceiver;private$signal;private$ajaxMode;private$startupCheck;private$lastCreatedRequest;private$lastCreatedRequestFlag;private$context;private$application;private$httpContext;private$httpRequest;private$httpResponse;private$session;private$user;function
__construct(){}final
function
getRequest(){return$this->request;}final
function
getPresenter($need=TRUE){return$this;}final
function
getUniqueId(){return'';}function
run(Application\Request$request){try{$this->request=$request;$this->payload=new\stdClass;$this->setParent($this->getParent(),$request->getPresenterName());$this->initGlobalParameters();$this->checkRequirements($this->getReflection());$this->startup();if(!$this->startupCheck){$class=$this->getReflection()->getMethod('startup')->getDeclaringClass()->getName();throw
new
Nette\InvalidStateException("Method $class::startup() or its descendant doesn't call parent::startup().");}$this->tryCall($this->formatActionMethod($this->action),$this->params);if($this->autoCanonicalize){$this->canonicalize();}if($this->httpRequest->isMethod('head')){$this->terminate();}$this->processSignal();$this->beforeRender();$this->tryCall($this->formatRenderMethod($this->view),$this->params);$this->afterRender();$this->saveGlobalState();if($this->isAjax()){$this->payload->state=$this->getGlobalState();}$this->sendTemplate();}catch(Application\AbortException$e){if($this->isAjax())try{$hasPayload=(array)$this->payload;unset($hasPayload['state']);if($this->response
instanceof
Responses\TextResponse&&$this->isControlInvalid()){$this->snippetMode=TRUE;$this->response->send($this->httpRequest,$this->httpResponse);$this->sendPayload();}elseif(!$this->response&&$hasPayload){$this->sendPayload();}}catch(Application\AbortException$e){}if($this->hasFlashSession()){$this->getFlashSession()->setExpiration($this->response
instanceof
Responses\RedirectResponse?'+ 30 seconds':'+ 3 seconds');}$this->onShutdown($this,$this->response);$this->shutdown($this->response);return$this->response;}}protected
function
startup(){$this->startupCheck=TRUE;}protected
function
beforeRender(){}protected
function
afterRender(){}protected
function
shutdown($response){}function
checkRequirements($element){$user=(array)$element->getAnnotation('User');if(in_array('loggedIn',$user)&&!$this->user->isLoggedIn()){throw
new
Application\ForbiddenRequestException;}}function
processSignal(){if($this->signal===NULL){return;}try{$component=$this->signalReceiver===''?$this:$this->getComponent($this->signalReceiver,FALSE);}catch(Nette\InvalidArgumentException$e){}if(isset($e)||$component===NULL){throw
new
BadSignalException("The signal receiver component '$this->signalReceiver' is not found.",NULL,isset($e)?$e:NULL);}elseif(!$component
instanceof
ISignalReceiver){throw
new
BadSignalException("The signal receiver component '$this->signalReceiver' is not ISignalReceiver implementor.");}$component->signalReceived($this->signal);$this->signal=NULL;}final
function
getSignal(){return$this->signal===NULL?NULL:array($this->signalReceiver,$this->signal);}final
function
isSignalReceiver($component,$signal=NULL){if($component
instanceof
Nette\ComponentModel\Component){$component=$component===$this?'':$component->lookupPath(__CLASS__,TRUE);}if($this->signal===NULL){return
FALSE;}elseif($signal===TRUE){return$component===''||strncmp($this->signalReceiver.'-',$component.'-',strlen($component)+1)===0;}elseif($signal===NULL){return$this->signalReceiver===$component;}else{return$this->signalReceiver===$component&&strcasecmp($signal,$this->signal)===0;}}final
function
getAction($fullyQualified=FALSE){return$fullyQualified?':'.$this->getName().':'.$this->action:$this->action;}function
changeAction($action){if(is_string($action)&&Nette\Utils\Strings::match($action,'#^[a-zA-Z0-9][a-zA-Z0-9_\x7f-\xff]*\z#')){$this->action=$action;$this->view=$action;}else{$this->error('Action name is not alphanumeric string.');}}final
function
getView(){return$this->view;}function
setView($view){$this->view=(string)$view;return$this;}final
function
getLayout(){return$this->layout;}function
setLayout($layout){$this->layout=$layout===FALSE?FALSE:(string)$layout;return$this;}function
sendTemplate(){$template=$this->getTemplate();if(!$template){return;}if($template
instanceof
Nette\Templating\IFileTemplate&&!$template->getFile()){$files=$this->formatTemplateFiles();foreach($files
as$file){if(is_file($file)){$template->setFile($file);break;}}if(!$template->getFile()){$file=preg_replace('#^.*([/\\\\].{1,70})\z#U',"\xE2\x80\xA6\$1",reset($files));$file=strtr($file,'/',DIRECTORY_SEPARATOR);$this->error("Page not found. Missing template '$file'.");}}$this->sendResponse(new
Responses\TextResponse($template));}function
findLayoutTemplateFile(){if($this->layout===FALSE){return;}$files=$this->formatLayoutTemplateFiles();foreach($files
as$file){if(is_file($file)){return$file;}}if($this->layout){$file=preg_replace('#^.*([/\\\\].{1,70})\z#U',"\xE2\x80\xA6\$1",reset($files));$file=strtr($file,'/',DIRECTORY_SEPARATOR);throw
new
Nette\FileNotFoundException("Layout not found. Missing template '$file'.");}}function
formatLayoutTemplateFiles(){$name=$this->getName();$presenter=substr($name,strrpos(':'.$name,':'));$layout=$this->layout?$this->layout:'layout';$dir=dirname($this->getReflection()->getFileName());$dir=is_dir("$dir/templates")?$dir:dirname($dir);$list=array("$dir/templates/$presenter/@$layout.latte","$dir/templates/$presenter.@$layout.latte","$dir/templates/$presenter/@$layout.phtml","$dir/templates/$presenter.@$layout.phtml");do{$list[]="$dir/templates/@$layout.latte";$list[]="$dir/templates/@$layout.phtml";$dir=dirname($dir);}while($dir&&($name=substr($name,0,strrpos($name,':'))));return$list;}function
formatTemplateFiles(){$name=$this->getName();$presenter=substr($name,strrpos(':'.$name,':'));$dir=dirname($this->getReflection()->getFileName());$dir=is_dir("$dir/templates")?$dir:dirname($dir);return
array("$dir/templates/$presenter/$this->view.latte","$dir/templates/$presenter.$this->view.latte","$dir/templates/$presenter/$this->view.phtml","$dir/templates/$presenter.$this->view.phtml");}static
function
formatActionMethod($action){return'action'.$action;}static
function
formatRenderMethod($view){return'render'.$view;}function
getPayload(){return$this->payload;}function
isAjax(){if($this->ajaxMode===NULL){$this->ajaxMode=$this->httpRequest->isAjax();}return$this->ajaxMode;}function
sendPayload(){$this->sendResponse(new
Responses\JsonResponse($this->payload));}function
sendJson($data){$this->sendResponse(new
Responses\JsonResponse($data));}function
sendResponse(Application\IResponse$response){$this->response=$response;$this->terminate();}function
terminate(){if(func_num_args()!==0){trigger_error(__METHOD__.' is not intended to send a Application\Response; use sendResponse() instead.',E_USER_WARNING);$this->sendResponse(func_get_arg(0));}throw
new
Application\AbortException();}function
forward($destination,$args=array()){if($destination
instanceof
Application\Request){$this->sendResponse(new
Responses\ForwardResponse($destination));}$this->createRequest($this,$destination,is_array($args)?$args:array_slice(func_get_args(),1),'forward');$this->sendResponse(new
Responses\ForwardResponse($this->lastCreatedRequest));}function
redirectUrl($url,$code=NULL){if($this->isAjax()){$this->payload->redirect=(string)$url;$this->sendPayload();}elseif(!$code){$code=$this->httpRequest->isMethod('post')?Http\IResponse::S303_POST_GET:Http\IResponse::S302_FOUND;}$this->sendResponse(new
Responses\RedirectResponse($url,$code));}function
error($message=NULL,$code=Http\IResponse::S404_NOT_FOUND){throw
new
Application\BadRequestException($message,$code);}function
backlink(){return$this->getAction(TRUE);}function
getLastCreatedRequest(){return$this->lastCreatedRequest;}function
getLastCreatedRequestFlag($flag){return!empty($this->lastCreatedRequestFlag[$flag]);}function
canonicalize(){if(!$this->isAjax()&&($this->request->isMethod('get')||$this->request->isMethod('head'))){try{$url=$this->createRequest($this,$this->action,$this->getGlobalState()+$this->request->getParameters(),'redirectX');}catch(InvalidLinkException$e){}if(isset($url)&&!$this->httpRequest->getUrl()->isEqual($url)){$this->sendResponse(new
Responses\RedirectResponse($url,Http\IResponse::S301_MOVED_PERMANENTLY));}}}function
lastModified($lastModified,$etag=NULL,$expire=NULL){if($expire!==NULL){$this->httpResponse->setExpiration($expire);}if(!$this->httpContext->isModified($lastModified,$etag)){$this->terminate();}}final
protected
function
createRequest($component,$destination,array$args,$mode){static$presenterFactory,$router,$refUrl;if($presenterFactory===NULL){$presenterFactory=$this->application->getPresenterFactory();$router=$this->application->getRouter();$refUrl=new
Http\Url($this->httpRequest->getUrl());$refUrl->setPath($this->httpRequest->getUrl()->getScriptPath());}$this->lastCreatedRequest=$this->lastCreatedRequestFlag=NULL;$a=strpos($destination,'#');if($a===FALSE){$fragment='';}else{$fragment=substr($destination,$a);$destination=substr($destination,0,$a);}$a=strpos($destination,'?');if($a!==FALSE){parse_str(substr($destination,$a+1),$args);$destination=substr($destination,0,$a);}$a=strpos($destination,'//');if($a===FALSE){$scheme=FALSE;}else{$scheme=substr($destination,0,$a);$destination=substr($destination,$a+2);}if(!$component
instanceof
Presenter||substr($destination,-1)==='!'){$signal=rtrim($destination,'!');$a=strrpos($signal,':');if($a!==FALSE){$component=$component->getComponent(strtr(substr($signal,0,$a),':','-'));$signal=(string)substr($signal,$a+1);}if($signal==NULL){throw
new
InvalidLinkException("Signal must be non-empty string.");}$destination='this';}if($destination==NULL){throw
new
InvalidLinkException("Destination must be non-empty string.");}$current=FALSE;$a=strrpos($destination,':');if($a===FALSE){$action=$destination==='this'?$this->action:$destination;$presenter=$this->getName();$presenterClass=get_class($this);}else{$action=(string)substr($destination,$a+1);if($destination[0]===':'){if($a<2){throw
new
InvalidLinkException("Missing presenter name in '$destination'.");}$presenter=substr($destination,1,$a-1);}else{$presenter=$this->getName();$b=strrpos($presenter,':');if($b===FALSE){$presenter=substr($destination,0,$a);}else{$presenter=substr($presenter,0,$b+1).substr($destination,0,$a);}}try{$presenterClass=$presenterFactory->getPresenterClass($presenter);}catch(Application\InvalidPresenterException$e){throw
new
InvalidLinkException($e->getMessage(),NULL,$e);}}if(isset($signal)){$reflection=new
PresenterComponentReflection(get_class($component));if($signal==='this'){$signal='';if(array_key_exists(0,$args)){throw
new
InvalidLinkException("Unable to pass parameters to 'this!' signal.");}}elseif(strpos($signal,self::NAME_SEPARATOR)===FALSE){$method=$component->formatSignalMethod($signal);if(!$reflection->hasCallableMethod($method)){throw
new
InvalidLinkException("Unknown signal '$signal', missing handler {$reflection->name}::$method()");}if($args){self::argsToParams(get_class($component),$method,$args);}}if($args&&array_intersect_key($args,$reflection->getPersistentParams())){$component->saveState($args);}if($args&&$component!==$this){$prefix=$component->getUniqueId().self::NAME_SEPARATOR;foreach($args
as$key=>$val){unset($args[$key]);$args[$prefix.$key]=$val;}}}if(is_subclass_of($presenterClass,__CLASS__)){if($action===''){$action=self::DEFAULT_ACTION;}$current=($action==='*'||strcasecmp($action,$this->action)===0)&&$presenterClass===get_class($this);$reflection=new
PresenterComponentReflection($presenterClass);if($args||$destination==='this'){$method=$presenterClass::formatActionMethod($action);if(!$reflection->hasCallableMethod($method)){$method=$presenterClass::formatRenderMethod($action);if(!$reflection->hasCallableMethod($method)){$method=NULL;}}if($method===NULL){if(array_key_exists(0,$args)){throw
new
InvalidLinkException("Unable to pass parameters to action '$presenter:$action', missing corresponding method.");}}elseif($destination==='this'){self::argsToParams($presenterClass,$method,$args,$this->params);}else{self::argsToParams($presenterClass,$method,$args);}}if($args&&array_intersect_key($args,$reflection->getPersistentParams())){$this->saveState($args,$reflection);}if($mode==='redirect'){$this->saveGlobalState();}$globalState=$this->getGlobalState($destination==='this'?NULL:$presenterClass);if($current&&$args){$tmp=$globalState+$this->params;foreach($args
as$key=>$val){if(http_build_query(array($val))!==(isset($tmp[$key])?http_build_query(array($tmp[$key])):'')){$current=FALSE;break;}}}$args+=$globalState;}$args[self::ACTION_KEY]=$action;if(!empty($signal)){$args[self::SIGNAL_KEY]=$component->getParameterId($signal);$current=$current&&$args[self::SIGNAL_KEY]===$this->getParameter(self::SIGNAL_KEY);}if(($mode==='redirect'||$mode==='forward')&&$this->hasFlashSession()){$args[self::FLASH_KEY]=$this->getParameter(self::FLASH_KEY);}$this->lastCreatedRequest=new
Application\Request($presenter,Application\Request::FORWARD,$args,array(),array());$this->lastCreatedRequestFlag=array('current'=>$current);if($mode==='forward'||$mode==='test'){return;}$url=$router->constructUrl($this->lastCreatedRequest,$refUrl);if($url===NULL){unset($args[self::ACTION_KEY]);$params=urldecode(http_build_query($args,NULL,', '));throw
new
InvalidLinkException("No route for $presenter:$action($params)");}if($mode==='link'&&$scheme===FALSE&&!$this->absoluteUrls){$hostUrl=$refUrl->getHostUrl();if(strncmp($url,$hostUrl,strlen($hostUrl))===0){$url=substr($url,strlen($hostUrl));}}return$url.$fragment;}private
static
function
argsToParams($class,$method,&$args,$supplemental=array()){$i=0;$rm=new\ReflectionMethod($class,$method);foreach($rm->getParameters()as$param){$name=$param->getName();if(array_key_exists($i,$args)){$args[$name]=$args[$i];unset($args[$i]);$i++;}elseif(array_key_exists($name,$args)){}elseif(array_key_exists($name,$supplemental)){$args[$name]=$supplemental[$name];}else{continue;}if($args[$name]===NULL){continue;}$def=$param->isDefaultValueAvailable()&&$param->isOptional()?$param->getDefaultValue():NULL;$type=$param->isArray()?'array':gettype($def);if(!PresenterComponentReflection::convertType($args[$name],$type)){throw
new
InvalidLinkException("Invalid value for parameter '$name' in method $class::$method(), expected ".($type==='NULL'?'scalar':$type).".");}if($args[$name]===$def||($def===NULL&&is_scalar($args[$name])&&(string)$args[$name]==='')){$args[$name]=NULL;}}if(array_key_exists($i,$args)){$method=$rm->getName();throw
new
InvalidLinkException("Passed more parameters than method $class::$method() expects.");}}protected
function
handleInvalidLink(InvalidLinkException$e){if($this->invalidLinkMode===self::INVALID_LINK_SILENT){return'#';}elseif($this->invalidLinkMode===self::INVALID_LINK_WARNING){return'error: '.$e->getMessage();}else{throw$e;}}function
storeRequest($expiration='+ 10 minutes'){$session=$this->session->getSection('Nette.Application/requests');do{$key=Nette\Utils\Strings::random(5);}while(isset($session[$key]));$session[$key]=array($this->user->getId(),$this->request);$session->setExpiration($expiration,$key);return$key;}function
restoreRequest($key){$session=$this->session->getSection('Nette.Application/requests');if(!isset($session[$key])||($session[$key][0]!==NULL&&$session[$key][0]!==$this->user->getId())){return;}$request=clone$session[$key][1];unset($session[$key]);$request->setFlag(Application\Request::RESTORED,TRUE);$params=$request->getParameters();$params[self::FLASH_KEY]=$this->getParameter(self::FLASH_KEY);$request->setParameters($params);$this->sendResponse(new
Responses\ForwardResponse($request));}static
function
getPersistentComponents(){return(array)Reflection\ClassType::from(get_called_class())->getAnnotation('persistent');}private
function
getGlobalState($forClass=NULL){$sinces=&$this->globalStateSinces;if($this->globalState===NULL){$state=array();foreach($this->globalParams
as$id=>$params){$prefix=$id.self::NAME_SEPARATOR;foreach($params
as$key=>$val){$state[$prefix.$key]=$val;}}$this->saveState($state,$forClass?new
PresenterComponentReflection($forClass):NULL);if($sinces===NULL){$sinces=array();foreach($this->getReflection()->getPersistentParams()as$name=>$meta){$sinces[$name]=$meta['since'];}}$components=$this->getReflection()->getPersistentComponents();$iterator=$this->getComponents(TRUE,'Nette\Application\UI\IStatePersistent');foreach($iterator
as$name=>$component){if($iterator->getDepth()===0){$since=isset($components[$name]['since'])?$components[$name]['since']:FALSE;}$prefix=$component->getUniqueId().self::NAME_SEPARATOR;$params=array();$component->saveState($params);foreach($params
as$key=>$val){$state[$prefix.$key]=$val;$sinces[$prefix.$key]=$since;}}}else{$state=$this->globalState;}if($forClass!==NULL){$since=NULL;foreach($state
as$key=>$foo){if(!isset($sinces[$key])){$x=strpos($key,self::NAME_SEPARATOR);$x=$x===FALSE?$key:substr($key,0,$x);$sinces[$key]=isset($sinces[$x])?$sinces[$x]:FALSE;}if($since!==$sinces[$key]){$since=$sinces[$key];$ok=$since&&(is_subclass_of($forClass,$since)||$forClass===$since);}if(!$ok){unset($state[$key]);}}}return$state;}protected
function
saveGlobalState(){foreach($this->globalParams
as$id=>$foo){$this->getComponent($id,FALSE);}$this->globalParams=array();$this->globalState=$this->getGlobalState();}private
function
initGlobalParameters(){$this->globalParams=array();$selfParams=array();$params=$this->request->getParameters();if($this->isAjax()){$params+=$this->request->getPost();}elseif(isset($this->request->post[self::SIGNAL_KEY])){$params[self::SIGNAL_KEY]=$this->request->post[self::SIGNAL_KEY];}foreach($params
as$key=>$value){if(!preg_match('#^((?:[a-z0-9_]+-)*)((?!\d+\z)[a-z0-9_]+)\z#i',$key,$matches)){continue;}elseif(!$matches[1]){$selfParams[$key]=$value;}else{$this->globalParams[substr($matches[1],0,-1)][$matches[2]]=$value;}}$this->changeAction(isset($selfParams[self::ACTION_KEY])?$selfParams[self::ACTION_KEY]:self::DEFAULT_ACTION);$this->signalReceiver=$this->getUniqueId();if(isset($selfParams[self::SIGNAL_KEY])){$param=$selfParams[self::SIGNAL_KEY];if(!is_string($param)){$this->error('Signal name is not string.');}$pos=strrpos($param,'-');if($pos){$this->signalReceiver=substr($param,0,$pos);$this->signal=substr($param,$pos+1);}else{$this->signalReceiver=$this->getUniqueId();$this->signal=$param;}if($this->signal==NULL){$this->signal=NULL;}}$this->loadState($selfParams);}final
function
popGlobalParameters($id){if(isset($this->globalParams[$id])){$res=$this->globalParams[$id];unset($this->globalParams[$id]);return$res;}else{return
array();}}function
hasFlashSession(){return!empty($this->params[self::FLASH_KEY])&&$this->session->hasSection('Nette.Application.Flash/'.$this->params[self::FLASH_KEY]);}function
getFlashSession(){if(empty($this->params[self::FLASH_KEY])){$this->params[self::FLASH_KEY]=Nette\Utils\Strings::random(4);}return$this->session->getSection('Nette.Application.Flash/'.$this->params[self::FLASH_KEY]);}final
function
injectPrimary(Nette\DI\Container$context,Application\Application$application,Http\Context$httpContext,Http\IRequest$httpRequest,Http\IResponse$httpResponse,Http\Session$session,Nette\Security\User$user){if($this->application!==NULL){throw
new
Nette\InvalidStateException("Method ".__METHOD__." is intended for initialization and should not be called more than once.");}$this->context=$context;$this->application=$application;$this->httpContext=$httpContext;$this->httpRequest=$httpRequest;$this->httpResponse=$httpResponse;$this->session=$session;$this->user=$user;}final
function
getContext(){return$this->context;}final
function
getService($name){trigger_error(__METHOD__.'() is deprecated; use dependency injection instead.',E_USER_DEPRECATED);return$this->context->getService($name);}protected
function
getHttpRequest(){return$this->httpRequest;}protected
function
getHttpResponse(){return$this->httpResponse;}protected
function
getHttpContext(){trigger_error(__METHOD__.'() is deprecated; use dependency injection instead.',E_USER_DEPRECATED);return$this->httpContext;}function
getApplication(){trigger_error(__METHOD__.'() is deprecated; use dependency injection instead.',E_USER_DEPRECATED);return$this->application;}function
getSession($namespace=NULL){$handler=$this->session;return$namespace===NULL?$handler:$handler->getSection($namespace);}function
getUser(){return$this->user;}}}namespace Nette\Reflection{use
Nette;use
Nette\ObjectMixin;class
ClassType
extends\ReflectionClass{static
function
from($class){return
new
static($class);}function
__toString(){return$this->getName();}function
is($type){return$this->isSubclassOf($type)||strcasecmp($this->getName(),ltrim($type,'\\'))===0;}function
getConstructor(){return($ref=parent::getConstructor())?Method::from($this->getName(),$ref->getName()):NULL;}function
getExtension(){return($name=$this->getExtensionName())?new
Extension($name):NULL;}function
getInterfaces(){$res=array();foreach(parent::getInterfaceNames()as$val){$res[$val]=new
static($val);}return$res;}function
getMethod($name){return
new
Method($this->getName(),$name);}function
getMethods($filter=-1){foreach($res=parent::getMethods($filter)as$key=>$val){$res[$key]=new
Method($this->getName(),$val->getName());}return$res;}function
getParentClass(){return($ref=parent::getParentClass())?new
static($ref->getName()):NULL;}function
getProperties($filter=-1){foreach($res=parent::getProperties($filter)as$key=>$val){$res[$key]=new
Property($this->getName(),$val->getName());}return$res;}function
getProperty($name){return
new
Property($this->getName(),$name);}function
hasAnnotation($name){$res=AnnotationsParser::getAll($this);return!empty($res[$name]);}function
getAnnotation($name){$res=AnnotationsParser::getAll($this);return
isset($res[$name])?end($res[$name]):NULL;}function
getAnnotations(){return
AnnotationsParser::getAll($this);}function
getDescription(){return$this->getAnnotation('description');}static
function
getReflection(){return
new
ClassType(get_called_class());}function
__call($name,$args){return
ObjectMixin::call($this,$name,$args);}function&__get($name){return
ObjectMixin::get($this,$name);}function
__set($name,$value){return
ObjectMixin::set($this,$name,$value);}function
__isset($name){return
ObjectMixin::has($this,$name);}function
__unset($name){ObjectMixin::remove($this,$name);}}}namespace Nette\Application\UI{use
Nette;use
Nette\Application\BadRequestException;class
PresenterComponentReflection
extends
Nette\Reflection\ClassType{private
static$ppCache=array();private
static$pcCache=array();private
static$mcCache=array();function
getPersistentParams($class=NULL){$class=$class===NULL?$this->getName():$class;$params=&self::$ppCache[$class];if($params!==NULL){return$params;}$params=array();if(is_subclass_of($class,'Nette\Application\UI\PresenterComponent')){$defaults=get_class_vars($class);foreach($class::getPersistentParams()as$name=>$default){if(is_int($name)){$name=$default;$default=$defaults[$name];}$params[$name]=array('def'=>$default,'since'=>$class);}foreach($this->getPersistentParams(get_parent_class($class))as$name=>$param){if(isset($params[$name])){$params[$name]['since']=$param['since'];continue;}$params[$name]=$param;}}return$params;}function
getPersistentComponents($class=NULL){$class=$class===NULL?$this->getName():$class;$components=&self::$pcCache[$class];if($components!==NULL){return$components;}$components=array();if(is_subclass_of($class,'Nette\Application\UI\Presenter')){foreach($class::getPersistentComponents()as$name=>$meta){if(is_string($meta)){$name=$meta;}$components[$name]=array('since'=>$class);}$components=$this->getPersistentComponents(get_parent_class($class))+$components;}return$components;}function
hasCallableMethod($method){$class=$this->getName();$cache=&self::$mcCache[strtolower($class.':'.$method)];if($cache===NULL)try{$cache=FALSE;$rm=Nette\Reflection\Method::from($class,$method);$cache=$this->isInstantiable()&&$rm->isPublic()&&!$rm->isAbstract()&&!$rm->isStatic();}catch(\ReflectionException$e){}return$cache;}static
function
combineArgs(\ReflectionFunctionAbstract$method,$args){$res=array();$i=0;foreach($method->getParameters()as$param){$name=$param->getName();if(isset($args[$name])){$res[$i++]=$args[$name];$type=$param->isArray()?'array':($param->isDefaultValueAvailable()&&$param->isOptional()?gettype($param->getDefaultValue()):'NULL');if(!self::convertType($res[$i-1],$type)){$mName=$method
instanceof\ReflectionMethod?$method->getDeclaringClass()->getName().'::'.$method->getName():$method->getName();throw
new
BadRequestException("Invalid value for parameter '$name' in method $mName(), expected ".($type==='NULL'?'scalar':$type).".");}}else{$res[$i++]=$param->isDefaultValueAvailable()&&$param->isOptional()?$param->getDefaultValue():($param->isArray()?array():NULL);}}return$res;}static
function
convertType(&$val,$type){if($val===NULL||is_object($val)){}elseif($type==='array'){if(!is_array($val)){return
FALSE;}}elseif(!is_scalar($val)){return
FALSE;}elseif($type!=='NULL'){$old=$val=($val===FALSE?'0':(string)$val);settype($val,$type);if($old!==($val===FALSE?'0':(string)$val)){return
FALSE;}}return
TRUE;}}}namespace Nette\Caching{use
Nette;use
Nette\Utils\Callback;class
Cache
extends
Nette\Object
implements\ArrayAccess{const
PRIORITY='priority',EXPIRATION='expire',EXPIRE='expire',SLIDING='sliding',TAGS='tags',FILES='files',ITEMS='items',CONSTS='consts',CALLBACKS='callbacks',ALL='all';const
NAMESPACE_SEPARATOR="\x00";private$storage;private$namespace;private$key;private$data;function
__construct(IStorage$storage,$namespace=NULL){$this->storage=$storage;$this->namespace=$namespace.self::NAMESPACE_SEPARATOR;}function
getStorage(){return$this->storage;}function
getNamespace(){return(string)substr($this->namespace,0,-1);}function
derive($namespace){$derived=new
static($this->storage,$this->namespace.$namespace);return$derived;}function
load($key,$fallback=NULL){$data=$this->storage->read($this->generateKey($key));if($data===NULL&&$fallback){return$this->save($key,Callback::closure($fallback));}return$data;}function
save($key,$data,array$dependencies=NULL){$this->release();$key=$this->generateKey($key);if($data
instanceof
Nette\Callback||$data
instanceof\Closure){$this->storage->lock($key);$data=call_user_func_array($data,array(&$dependencies));}if($data===NULL){$this->storage->remove($key);}else{$this->storage->write($key,$data,$this->completeDependencies($dependencies,$data));return$data;}}private
function
completeDependencies($dp,$data){if(is_object($data)){$dp[self::CALLBACKS][]=array(array(__CLASS__,'checkSerializationVersion'),get_class($data),Nette\Reflection\ClassType::from($data)->getAnnotation('serializationVersion'));}if(isset($dp[Cache::EXPIRATION])){$dp[Cache::EXPIRATION]=Nette\DateTime::from($dp[Cache::EXPIRATION])->format('U')-time();}if(isset($dp[self::FILES])){$dp[self::CALLBACKS][]=array(array(__CLASS__,'checkFiles'),$dp[self::FILES],time());unset($dp[self::FILES]);}if(isset($dp[self::ITEMS])){$dp[self::ITEMS]=array_unique(array_map(array($this,'generateKey'),(array)$dp[self::ITEMS]));}if(isset($dp[self::CONSTS])){foreach(array_unique((array)$dp[self::CONSTS])as$item){$dp[self::CALLBACKS][]=array(array(__CLASS__,'checkConst'),$item,constant($item));}unset($dp[self::CONSTS]);}if(!is_array($dp)){$dp=array();}return$dp;}function
remove($key){$this->save($key,NULL);}function
clean(array$conditions=NULL){$this->release();$this->storage->clean((array)$conditions);}function
call($function){$key=func_get_args();return$this->load($key,function()use($function,$key){return
Callback::invokeArgs($function,array_slice($key,1));});}function
wrap($function,array$dependencies=NULL){$cache=$this;return
function()use($cache,$function,$dependencies){$key=array($function,func_get_args());$data=$cache->load($key);if($data===NULL){$data=$cache->save($key,Callback::invokeArgs($function,$key[1]),$dependencies);}return$data;};}function
start($key){$data=$this->load($key);if($data===NULL){return
new
OutputHelper($this,$key);}echo$data;}protected
function
generateKey($key){return$this->namespace.md5(is_scalar($key)?$key:serialize($key));}function
offsetSet($key,$data){$this->save($key,$data);}function
offsetGet($key){$key=is_scalar($key)?(string)$key:serialize($key);if($this->key!==$key){$this->key=$key;$this->data=$this->load($key);}return$this->data;}function
offsetExists($key){$this->release();return$this->offsetGet($key)!==NULL;}function
offsetUnset($key){$this->save($key,NULL);}function
release(){$this->key=$this->data=NULL;}static
function
checkCallbacks($callbacks){foreach($callbacks
as$callback){if(!call_user_func_array(array_shift($callback),$callback)){return
FALSE;}}return
TRUE;}private
static
function
checkConst($const,$value){return
defined($const)&&constant($const)===$value;}private
static
function
checkFiles($files,$time){foreach((array)$files
as$file){if(@filemtime($file)>$time){return
FALSE;}}return
TRUE;}private
static
function
checkSerializationVersion($class,$value){return
Nette\Reflection\ClassType::from($class)->getAnnotation('serializationVersion')===$value;}}class
OutputHelper
extends
Nette\Object{public$dependencies;private$cache;private$key;function
__construct(Cache$cache,$key){$this->cache=$cache;$this->key=$key;ob_start();}function
end(array$dependencies=NULL){if($this->cache===NULL){throw
new
Nette\InvalidStateException('Output cache has already been saved.');}$this->cache->save($this->key,ob_get_flush(),(array)$dependencies+(array)$this->dependencies);$this->cache=NULL;}}}namespace Nette\Caching\Storages{use
Nette;class
DevNullStorage
extends
Nette\Object
implements
Nette\Caching\IStorage{function
read($key){}function
lock($key){}function
write($key,$data,array$dependencies){}function
remove($key){}function
clean(array$conditions){}}use
Nette\Caching\Cache;class
FileJournal
extends
Nette\Object
implements
IJournal{const
FILE='btfj.dat';const
FILE_MAGIC=0x6274666A;const
INDEX_MAGIC=0x696E6465;const
DATA_MAGIC=0x64617461;const
NODE_SIZE=4096;const
BITROT=12;const
HEADER_SIZE=4096;const
INT32_SIZE=4;const
INFO='i',TYPE='t',IS_LEAF='il',PREV_NODE='p',END='e',MAX='m',INDEX_DATA='id',LAST_INDEX='l';const
TAGS='t',PRIORITY='p',ENTRIES='e';const
DATA='d',KEY='k',DELETED='d';public
static$debug=FALSE;private$file;private$handle;private$lastNode=2;private$processIdentifier;private$nodeCache=array();private$nodeChanged=array();private$toCommit=array();private$deletedLinks=array();private$dataNodeFreeSpace=array();private
static$startNode=array(self::TAGS=>0,self::PRIORITY=>1,self::ENTRIES=>2,self::DATA=>3);function
__construct($dir){$this->file=$dir.'/'.self::FILE;}function
__destruct(){if($this->handle){$this->headerCommit();flock($this->handle,LOCK_UN);fclose($this->handle);$this->handle=FALSE;}}function
write($key,array$dependencies){$this->lock();$priority=!isset($dependencies[Cache::PRIORITY])?FALSE:(int)$dependencies[Cache::PRIORITY];$tags=empty($dependencies[Cache::TAGS])?FALSE:(array)$dependencies[Cache::TAGS];$exists=FALSE;$keyHash=crc32($key);list($entriesNodeId,$entriesNode)=$this->findIndexNode(self::ENTRIES,$keyHash);if(isset($entriesNode[$keyHash])){$entries=$this->mergeIndexData($entriesNode[$keyHash]);foreach($entries
as$link=>$foo){$dataNode=$this->getNode($link>>self::BITROT);if($dataNode[$link][self::KEY]===$key){if($dataNode[$link][self::TAGS]==$tags&&$dataNode[$link][self::PRIORITY]===$priority){if($dataNode[$link][self::DELETED]){$dataNode[$link][self::DELETED]=FALSE;$this->saveNode($link>>self::BITROT,$dataNode);}$exists=TRUE;}else{$toDelete=array();foreach($dataNode[$link][self::TAGS]as$tag){$toDelete[self::TAGS][$tag][$link]=TRUE;}if($dataNode[$link][self::PRIORITY]!==FALSE){$toDelete[self::PRIORITY][$dataNode[$link][self::PRIORITY]][$link]=TRUE;}$toDelete[self::ENTRIES][$keyHash][$link]=TRUE;$this->cleanFromIndex($toDelete);unset($dataNode[$link]);$this->saveNode($link>>self::BITROT,$dataNode);list($entriesNodeId,$entriesNode)=$this->findIndexNode(self::ENTRIES,$keyHash);}break;}}}if($exists===FALSE){$requiredSize=strlen($key)+75;if($tags){foreach($tags
as$tag){$requiredSize+=strlen($tag)+13;}}$requiredSize+=$priority?10:1;$freeDataNode=$this->findFreeDataNode($requiredSize);$data=$this->getNode($freeDataNode);if($data===FALSE){$data=array(self::INFO=>array(self::LAST_INDEX=>($freeDataNode<<self::BITROT),self::TYPE=>self::DATA));}$dataNodeKey=$this->findNextFreeKey($freeDataNode,$data);$data[$dataNodeKey]=array(self::KEY=>$key,self::TAGS=>$tags?$tags:array(),self::PRIORITY=>$priority,self::DELETED=>FALSE);$this->saveNode($freeDataNode,$data);$entriesNode[$keyHash][$dataNodeKey]=1;$this->saveNode($entriesNodeId,$entriesNode);if($tags){foreach($tags
as$tag){list($nodeId,$node)=$this->findIndexNode(self::TAGS,$tag);$node[$tag][$dataNodeKey]=1;$this->saveNode($nodeId,$node);}}if($priority!==FALSE){list($nodeId,$node)=$this->findIndexNode(self::PRIORITY,$priority);$node[$priority][$dataNodeKey]=1;$this->saveNode($nodeId,$node);}}$this->commit();$this->unlock();}function
clean(array$conditions){$this->lock();if(!empty($conditions[Cache::ALL])){$this->nodeCache=$this->nodeChanged=$this->dataNodeFreeSpace=array();$this->deleteAll();$this->unlock();return
NULL;}$toDelete=array(self::TAGS=>array(),self::PRIORITY=>array(),self::ENTRIES=>array());$entries=array();if(!empty($conditions[Cache::TAGS])){$entries=$this->cleanTags((array)$conditions[Cache::TAGS],$toDelete);}if(isset($conditions[Cache::PRIORITY])){$this->arrayAppend($entries,$this->cleanPriority((int)$conditions[Cache::PRIORITY],$toDelete));}$this->deletedLinks=array();$this->cleanFromIndex($toDelete);$this->commit();$this->unlock();return$entries;}private
function
cleanTags(array$tags,array&$toDelete){$entries=array();foreach($tags
as$tag){list($nodeId,$node)=$this->findIndexNode(self::TAGS,$tag);if(isset($node[$tag])){$ent=$this->cleanLinks($this->mergeIndexData($node[$tag]),$toDelete);$this->arrayAppend($entries,$ent);}}return$entries;}private
function
cleanPriority($priority,array&$toDelete){list($nodeId,$node)=$this->findIndexNode(self::PRIORITY,$priority);ksort($node);$allData=array();foreach($node
as$prior=>$data){if($prior===self::INFO){continue;}elseif($prior>$priority){break;}$this->arrayAppendKeys($allData,$this->mergeIndexData($data));}$nodeInfo=$node[self::INFO];while($nodeInfo[self::PREV_NODE]!==-1){$nodeId=$nodeInfo[self::PREV_NODE];$node=$this->getNode($nodeId);if($node===FALSE){if(self::$debug){throw
new
Nette\InvalidStateException("Cannot load node number $nodeId.");}break;}$nodeInfo=$node[self::INFO];unset($node[self::INFO]);foreach($node
as$prior=>$data){$this->arrayAppendKeys($allData,$this->mergeIndexData($data));}}return$this->cleanLinks($allData,$toDelete);}private
function
cleanLinks(array$data,array&$toDelete){$return=array();$data=array_keys($data);sort($data);$max=count($data);$data[]=0;$i=0;while($i<$max){$searchLink=$data[$i];if(isset($this->deletedLinks[$searchLink])){++$i;continue;}$nodeId=$searchLink>>self::BITROT;$node=$this->getNode($nodeId);if($node===FALSE){if(self::$debug){throw
new
Nette\InvalidStateException("Cannot load node number $nodeId.");}++$i;continue;}do{$link=$data[$i];if(!isset($node[$link])){if(self::$debug){throw
new
Nette\InvalidStateException("Link with ID $searchLink is not in node $nodeId.");}continue;}elseif(isset($this->deletedLinks[$link])){continue;}$nodeLink=&$node[$link];if(!$nodeLink[self::DELETED]){$nodeLink[self::DELETED]=TRUE;$return[]=$nodeLink[self::KEY];}else{foreach($nodeLink[self::TAGS]as$tag){$toDelete[self::TAGS][$tag][$link]=TRUE;}if($nodeLink[self::PRIORITY]!==FALSE){$toDelete[self::PRIORITY][$nodeLink[self::PRIORITY]][$link]=TRUE;}$toDelete[self::ENTRIES][crc32($nodeLink[self::KEY])][$link]=TRUE;unset($node[$link]);$this->deletedLinks[$link]=TRUE;}}while(($data[++$i]>>self::BITROT)===$nodeId);$this->saveNode($nodeId,$node);}return$return;}private
function
cleanFromIndex(array$toDeleteFromIndex){foreach($toDeleteFromIndex
as$type=>$toDelete){ksort($toDelete);while(!empty($toDelete)){reset($toDelete);$searchKey=key($toDelete);list($masterNodeId,$masterNode)=$this->findIndexNode($type,$searchKey);if(!isset($masterNode[$searchKey])){if(self::$debug){throw
new
Nette\InvalidStateException('Bad index.');}unset($toDelete[$searchKey]);continue;}foreach($toDelete
as$key=>$links){if(isset($masterNode[$key])){foreach($links
as$link=>$foo){if(isset($masterNode[$key][$link])){unset($masterNode[$key][$link],$links[$link]);}}if(!empty($links)&&isset($masterNode[$key][self::INDEX_DATA])){$this->cleanIndexData($masterNode[$key][self::INDEX_DATA],$links,$masterNode[$key]);}if(empty($masterNode[$key])){unset($masterNode[$key]);}unset($toDelete[$key]);}else{break;}}$this->saveNode($masterNodeId,$masterNode);}}}private
function
mergeIndexData(array$data){while(isset($data[self::INDEX_DATA])){$id=$data[self::INDEX_DATA];unset($data[self::INDEX_DATA]);$childNode=$this->getNode($id);if($childNode===FALSE){if(self::$debug){throw
new
Nette\InvalidStateException("Cannot load node number $id.");}break;}$this->arrayAppendKeys($data,$childNode[self::INDEX_DATA]);}return$data;}private
function
cleanIndexData($nextNodeId,array$links,&$masterNodeLink){$prev=-1;while($nextNodeId&&!empty($links)){$nodeId=$nextNodeId;$node=$this->getNode($nodeId);if($node===FALSE){if(self::$debug){throw
new
Nette\InvalidStateException("Cannot load node number $nodeId.");}break;}foreach($links
as$link=>$foo){if(isset($node[self::INDEX_DATA][$link])){unset($node[self::INDEX_DATA][$link],$links[$link]);}}if(isset($node[self::INDEX_DATA][self::INDEX_DATA])){$nextNodeId=$node[self::INDEX_DATA][self::INDEX_DATA];}else{$nextNodeId=FALSE;}if(empty($node[self::INDEX_DATA])||(count($node[self::INDEX_DATA])===1&&$nextNodeId)){if($prev===-1){if($nextNodeId===FALSE){unset($masterNodeLink[self::INDEX_DATA]);}else{$masterNodeLink[self::INDEX_DATA]=$nextNodeId;}}else{$prevNode=$this->getNode($prev);if($prevNode===FALSE){if(self::$debug){throw
new
Nette\InvalidStateException("Cannot load node number $prev.");}}else{if($nextNodeId===FALSE){unset($prevNode[self::INDEX_DATA][self::INDEX_DATA]);if(empty($prevNode[self::INDEX_DATA])){unset($prevNode[self::INDEX_DATA]);}}else{$prevNode[self::INDEX_DATA][self::INDEX_DATA]=$nextNodeId;}$this->saveNode($prev,$prevNode);}}unset($node[self::INDEX_DATA]);}else{$prev=$nodeId;}$this->saveNode($nodeId,$node);}}private
function
getNode($id){if(isset($this->nodeCache[$id])){return$this->nodeCache[$id];}$binary=stream_get_contents($this->handle,self::NODE_SIZE,self::HEADER_SIZE+self::NODE_SIZE*$id);if(empty($binary)){return
FALSE;}list(,$magic,$length)=unpack('N2',$binary);if($magic!==self::INDEX_MAGIC&&$magic!==self::DATA_MAGIC){if(!empty($magic)){if(self::$debug){throw
new
Nette\InvalidStateException("Node $id has malformed header.");}$this->deleteNode($id);}return
FALSE;}$data=substr($binary,2*self::INT32_SIZE,$length-2*self::INT32_SIZE);$node=@unserialize($data);if($node===FALSE){$this->deleteNode($id);if(self::$debug){throw
new
Nette\InvalidStateException("Cannot unserialize node number $id.");}return
FALSE;}return$this->nodeCache[$id]=$node;}private
function
saveNode($id,array$node){if(count($node)===1){$nodeInfo=$node[self::INFO];if($nodeInfo[self::TYPE]!==self::DATA){if($nodeInfo[self::END]!==-1){$this->nodeCache[$id]=$node;$this->nodeChanged[$id]=TRUE;return;}if($nodeInfo[self::MAX]===-1){$max=PHP_INT_MAX;}else{$max=$nodeInfo[self::MAX];}list(,,$parentId)=$this->findIndexNode($nodeInfo[self::TYPE],$max,$id);if($parentId!==-1&&$parentId!==$id){$parentNode=$this->getNode($parentId);if($parentNode===FALSE){if(self::$debug){throw
new
Nette\InvalidStateException("Cannot load node number $parentId.");}}else{if($parentNode[self::INFO][self::END]===$id){if(count($parentNode)===1){$parentNode[self::INFO][self::END]=-1;}else{end($parentNode);$lastKey=key($parentNode);$parentNode[self::INFO][self::END]=$parentNode[$lastKey];unset($parentNode[$lastKey]);}}else{unset($parentNode[$nodeInfo[self::MAX]]);}$this->saveNode($parentId,$parentNode);}}if($nodeInfo[self::TYPE]===self::PRIORITY){if($nodeInfo[self::MAX]===-1){if($nodeInfo[self::PREV_NODE]!==-1){$prevNode=$this->getNode($nodeInfo[self::PREV_NODE]);if($prevNode===FALSE){if(self::$debug){throw
new
Nette\InvalidStateException("Cannot load node number {$nodeInfo[self::PREV_NODE]}.");}}else{$prevNode[self::INFO][self::MAX]=-1;$this->saveNode($nodeInfo[self::PREV_NODE],$prevNode);}}}else{list($nextId,$nextNode)=$this->findIndexNode($nodeInfo[self::TYPE],$nodeInfo[self::MAX]+1,NULL,$id);if($nextId!==-1&&$nextId!==$id){$nextNode[self::INFO][self::PREV_NODE]=$nodeInfo[self::PREV_NODE];$this->saveNode($nextId,$nextNode);}}}}$this->nodeCache[$id]=FALSE;}else{$this->nodeCache[$id]=$node;}$this->nodeChanged[$id]=TRUE;}private
function
commit(){do{foreach($this->nodeChanged
as$id=>$foo){if($this->prepareNode($id,$this->nodeCache[$id])){unset($this->nodeChanged[$id]);}}}while(!empty($this->nodeChanged));foreach($this->toCommit
as$node=>$str){$this->commitNode($node,$str);}$this->toCommit=array();}private
function
prepareNode($id,$node){if($node===FALSE){if($id<$this->lastNode){$this->lastNode=$id;}unset($this->nodeCache[$id]);unset($this->dataNodeFreeSpace[$id]);$this->deleteNode($id);return
TRUE;}$data=serialize($node);$dataSize=strlen($data)+2*self::INT32_SIZE;$isData=$node[self::INFO][self::TYPE]===self::DATA;if($dataSize>self::NODE_SIZE){if($isData){throw
new
Nette\InvalidStateException('Saving node is bigger than maximum node size.');}else{$this->bisectNode($id,$node);return
FALSE;}}$this->toCommit[$id]=pack('N2',$isData?self::DATA_MAGIC:self::INDEX_MAGIC,$dataSize).$data;if($this->lastNode<$id){$this->lastNode=$id;}if($isData){$this->dataNodeFreeSpace[$id]=self::NODE_SIZE-$dataSize;}return
TRUE;}private
function
commitNode($id,$str){fseek($this->handle,self::HEADER_SIZE+self::NODE_SIZE*$id);$written=fwrite($this->handle,$str);if($written===FALSE){throw
new
Nette\InvalidStateException("Cannot write node number $id to journal.");}}private
function
findIndexNode($type,$search,$childId=NULL,$prevId=NULL){$nodeId=self::$startNode[$type];$parentId=-1;while(TRUE){$node=$this->getNode($nodeId);if($node===FALSE){return
array($nodeId,array(self::INFO=>array(self::TYPE=>$type,self::IS_LEAF=>TRUE,self::PREV_NODE=>-1,self::END=>-1,self::MAX=>-1)),$parentId);}if($node[self::INFO][self::IS_LEAF]||$nodeId===$childId||$node[self::INFO][self::PREV_NODE]===$prevId){return
array($nodeId,$node,$parentId);}$parentId=$nodeId;if(isset($node[$search])){$nodeId=$node[$search];}else{foreach($node
as$key=>$childNode){if($key>$search
and$key!==self::INFO){$nodeId=$childNode;continue
2;}}$nodeId=$node[self::INFO][self::END];}}}private
function
findFreeNode($count=1){$id=$this->lastNode;$nodesId=array();do{if(isset($this->nodeCache[$id])){++$id;continue;}$offset=self::HEADER_SIZE+self::NODE_SIZE*$id;$binary=stream_get_contents($this->handle,self::INT32_SIZE,$offset);if(empty($binary)){$nodesId[]=$id;}else{list(,$magic)=unpack('N',$binary);if($magic!==self::INDEX_MAGIC&&$magic!==self::DATA_MAGIC){$nodesId[]=$id;}}++$id;}while(count($nodesId)!==$count);if($count===1){return$nodesId[0];}else{return$nodesId;}}private
function
findFreeDataNode($size){foreach($this->dataNodeFreeSpace
as$id=>$freeSpace){if($freeSpace>$size){return$id;}}$id=self::$startNode[self::DATA];while(TRUE){if(isset($this->dataNodeFreeSpace[$id])||isset($this->nodeCache[$id])){++$id;continue;}$offset=self::HEADER_SIZE+self::NODE_SIZE*$id;$binary=stream_get_contents($this->handle,2*self::INT32_SIZE,$offset);if(empty($binary)){$this->dataNodeFreeSpace[$id]=self::NODE_SIZE;return$id;}list(,$magic,$nodeSize)=unpack('N2',$binary);if(empty($magic)){$this->dataNodeFreeSpace[$id]=self::NODE_SIZE;return$id;}elseif($magic===self::DATA_MAGIC){$freeSpace=self::NODE_SIZE-$nodeSize;$this->dataNodeFreeSpace[$id]=$freeSpace;if($freeSpace>$size){return$id;}}++$id;}}private
function
bisectNode($id,array$node){$nodeInfo=$node[self::INFO];unset($node[self::INFO]);if(count($node)===1){$key=key($node);$dataId=$this->findFreeDataNode(self::NODE_SIZE);$this->saveNode($dataId,array(self::INDEX_DATA=>$node[$key],self::INFO=>array(self::TYPE=>self::DATA,self::LAST_INDEX=>($dataId<<self::BITROT))));unset($node[$key]);$node[$key][self::INDEX_DATA]=$dataId;$node[self::INFO]=$nodeInfo;$this->saveNode($id,$node);return;}ksort($node);$halfCount=ceil(count($node)/2);list($first,$second)=array_chunk($node,$halfCount,TRUE);end($first);$halfKey=key($first);if($id<=2){list($firstId,$secondId)=$this->findFreeNode(2);$first[self::INFO]=array(self::TYPE=>$nodeInfo[self::TYPE],self::IS_LEAF=>$nodeInfo[self::IS_LEAF],self::PREV_NODE=>-1,self::END=>-1,self::MAX=>$halfKey);$this->saveNode($firstId,$first);$second[self::INFO]=array(self::TYPE=>$nodeInfo[self::TYPE],self::IS_LEAF=>$nodeInfo[self::IS_LEAF],self::PREV_NODE=>$firstId,self::END=>$nodeInfo[self::END],self::MAX=>-1);$this->saveNode($secondId,$second);$parentNode=array(self::INFO=>array(self::TYPE=>$nodeInfo[self::TYPE],self::IS_LEAF=>FALSE,self::PREV_NODE=>-1,self::END=>$secondId,self::MAX=>-1),$halfKey=>$firstId);$this->saveNode($id,$parentNode);}else{$firstId=$this->findFreeNode();$first[self::INFO]=array(self::TYPE=>$nodeInfo[self::TYPE],self::IS_LEAF=>$nodeInfo[self::IS_LEAF],self::PREV_NODE=>$nodeInfo[self::PREV_NODE],self::END=>-1,self::MAX=>$halfKey);$this->saveNode($firstId,$first);$second[self::INFO]=array(self::TYPE=>$nodeInfo[self::TYPE],self::IS_LEAF=>$nodeInfo[self::IS_LEAF],self::PREV_NODE=>$firstId,self::END=>$nodeInfo[self::END],self::MAX=>$nodeInfo[self::MAX]);$this->saveNode($id,$second);list(,,$parent)=$this->findIndexNode($nodeInfo[self::TYPE],$halfKey);$parentNode=$this->getNode($parent);if($parentNode===FALSE){if(self::$debug){throw
new
Nette\InvalidStateException("Cannot load node number $parent.");}}else{$parentNode[$halfKey]=$firstId;ksort($parentNode);$this->saveNode($parent,$parentNode);}}}private
function
headerCommit(){fseek($this->handle,self::INT32_SIZE);@fwrite($this->handle,pack('N',$this->lastNode));}private
function
deleteNode($id){fseek($this->handle,0,SEEK_END);$end=ftell($this->handle);if($end<=(self::HEADER_SIZE+self::NODE_SIZE*($id+1))){$packedNull=pack('N',0);do{$binary=stream_get_contents($this->handle,self::INT32_SIZE,(self::HEADER_SIZE+self::NODE_SIZE*--$id));}while(empty($binary)||$binary===$packedNull);if(!ftruncate($this->handle,self::HEADER_SIZE+self::NODE_SIZE*($id+1))){throw
new
Nette\InvalidStateException('Cannot truncate journal file.');}}else{fseek($this->handle,self::HEADER_SIZE+self::NODE_SIZE*$id);$written=fwrite($this->handle,pack('N',0));if($written!==self::INT32_SIZE){throw
new
Nette\InvalidStateException("Cannot delete node number $id from journal.");}}}private
function
deleteAll(){if(!ftruncate($this->handle,self::HEADER_SIZE)){throw
new
Nette\InvalidStateException('Cannot truncate journal file.');}}private
function
lock(){if(!$this->handle){$this->prepare();}if(!flock($this->handle,LOCK_EX)){throw
new
Nette\InvalidStateException("Cannot acquire exclusive lock on journal file '$this->file'.");}$lastProcessIdentifier=stream_get_contents($this->handle,self::INT32_SIZE,self::INT32_SIZE*2);if($lastProcessIdentifier!==$this->processIdentifier){$this->nodeCache=$this->dataNodeFreeSpace=array();fseek($this->handle,self::INT32_SIZE*2);fwrite($this->handle,$this->processIdentifier);}}private
function
prepare(){if(!file_exists($this->file)){$init=@fopen($this->file,'xb');if(!$init){clearstatcache();if(!file_exists($this->file)){throw
new
Nette\InvalidStateException("Cannot create journal file '$this->file'.");}}else{$written=fwrite($init,pack('N2',self::FILE_MAGIC,$this->lastNode));fclose($init);if($written!==self::INT32_SIZE*2){throw
new
Nette\InvalidStateException("Cannot write journal header.");}}}$this->handle=fopen($this->file,'r+b');if(!$this->handle){throw
new
Nette\InvalidStateException("Cannot open journal file '$this->file'.");}if(!flock($this->handle,LOCK_SH)){throw
new
Nette\InvalidStateException('Cannot acquire shared lock on journal.');}$header=stream_get_contents($this->handle,2*self::INT32_SIZE,0);flock($this->handle,LOCK_UN);list(,$fileMagic,$this->lastNode)=unpack('N2',$header);if($fileMagic!==self::FILE_MAGIC){fclose($this->handle);$this->handle=FALSE;throw
new
Nette\InvalidStateException("Malformed journal file '$this->file'.");}$this->processIdentifier=pack('N',mt_rand());}private
function
unlock(){if($this->handle){fflush($this->handle);flock($this->handle,LOCK_UN);}}private
function
findNextFreeKey($nodeId,array&$nodeData){$newKey=$nodeData[self::INFO][self::LAST_INDEX]+1;$maxKey=($nodeId+1)<<self::BITROT;if($newKey>=$maxKey){$start=$nodeId<<self::BITROT;for($i=$start;$i<$maxKey;$i++){if(!isset($nodeData[$i])){return$i;}}throw
new
Nette\InvalidStateException("Node $nodeId is full.");}else{return++$nodeData[self::INFO][self::LAST_INDEX];}}private
function
arrayAppend(array&$array,array$append){foreach($append
as$value){$array[]=$value;}}private
function
arrayAppendKeys(array&$array,array$append){foreach($append
as$key=>$value){$array[$key]=$value;}}}class
FileStorage
extends
Nette\Object
implements
Nette\Caching\IStorage{const
META_HEADER_LEN=28,META_TIME='time',META_SERIALIZED='serialized',META_EXPIRE='expire',META_DELTA='delta',META_ITEMS='di',META_CALLBACKS='callbacks';const
FILE='file',HANDLE='handle';public
static$gcProbability=0.001;public
static$useDirectories=TRUE;private$dir;private$useDirs;private$journal;private$locks;function
__construct($dir,IJournal$journal=NULL){$this->dir=realpath($dir);if($this->dir===FALSE){throw
new
Nette\DirectoryNotFoundException("Directory '$dir' not found.");}$this->useDirs=(bool)static::$useDirectories;$this->journal=$journal;if(mt_rand()/mt_getrandmax()<static::$gcProbability){$this->clean(array());}}function
read($key){$meta=$this->readMetaAndLock($this->getCacheFile($key),LOCK_SH);if($meta&&$this->verify($meta)){return$this->readData($meta);}else{return
NULL;}}private
function
verify($meta){do{if(!empty($meta[self::META_DELTA])){if(filemtime($meta[self::FILE])+$meta[self::META_DELTA]<time()){break;}touch($meta[self::FILE]);}elseif(!empty($meta[self::META_EXPIRE])&&$meta[self::META_EXPIRE]<time()){break;}if(!empty($meta[self::META_CALLBACKS])&&!Cache::checkCallbacks($meta[self::META_CALLBACKS])){break;}if(!empty($meta[self::META_ITEMS])){foreach($meta[self::META_ITEMS]as$depFile=>$time){$m=$this->readMetaAndLock($depFile,LOCK_SH);if($m[self::META_TIME]!==$time||($m&&!$this->verify($m))){break
2;}}}return
TRUE;}while(FALSE);$this->delete($meta[self::FILE],$meta[self::HANDLE]);return
FALSE;}function
lock($key){$cacheFile=$this->getCacheFile($key);if($this->useDirs&&!is_dir($dir=dirname($cacheFile))){@mkdir($dir);}$handle=@fopen($cacheFile,'r+b');if(!$handle){$handle=fopen($cacheFile,'wb');if(!$handle){return;}}$this->locks[$key]=$handle;flock($handle,LOCK_EX);}function
write($key,$data,array$dp){$meta=array(self::META_TIME=>microtime());if(isset($dp[Cache::EXPIRATION])){if(empty($dp[Cache::SLIDING])){$meta[self::META_EXPIRE]=$dp[Cache::EXPIRATION]+time();}else{$meta[self::META_DELTA]=(int)$dp[Cache::EXPIRATION];}}if(isset($dp[Cache::ITEMS])){foreach((array)$dp[Cache::ITEMS]as$item){$depFile=$this->getCacheFile($item);$m=$this->readMetaAndLock($depFile,LOCK_SH);$meta[self::META_ITEMS][$depFile]=$m[self::META_TIME];unset($m);}}if(isset($dp[Cache::CALLBACKS])){$meta[self::META_CALLBACKS]=$dp[Cache::CALLBACKS];}if(!isset($this->locks[$key])){$this->lock($key);if(!isset($this->locks[$key])){return;}}$handle=$this->locks[$key];unset($this->locks[$key]);$cacheFile=$this->getCacheFile($key);if(isset($dp[Cache::TAGS])||isset($dp[Cache::PRIORITY])){if(!$this->journal){throw
new
Nette\InvalidStateException('CacheJournal has not been provided.');}$this->journal->write($cacheFile,$dp);}ftruncate($handle,0);if(!is_string($data)){$data=serialize($data);$meta[self::META_SERIALIZED]=TRUE;}$head=serialize($meta).'?>';$head='<?php //netteCache[01]'.str_pad((string)strlen($head),6,'0',STR_PAD_LEFT).$head;$headLen=strlen($head);$dataLen=strlen($data);do{if(fwrite($handle,str_repeat("\x00",$headLen),$headLen)!==$headLen){break;}if(fwrite($handle,$data,$dataLen)!==$dataLen){break;}fseek($handle,0);if(fwrite($handle,$head,$headLen)!==$headLen){break;}flock($handle,LOCK_UN);fclose($handle);return;}while(FALSE);$this->delete($cacheFile,$handle);}function
remove($key){unset($this->locks[$key]);$this->delete($this->getCacheFile($key));}function
clean(array$conditions){$all=!empty($conditions[Cache::ALL]);$collector=empty($conditions);if($all||$collector){$now=time();foreach(Nette\Utils\Finder::find('_*')->from($this->dir)->childFirst()as$entry){$path=(string)$entry;if($entry->isDir()){@rmdir($path);continue;}if($all){$this->delete($path);}else{$meta=$this->readMetaAndLock($path,LOCK_SH);if(!$meta){continue;}if((!empty($meta[self::META_DELTA])&&filemtime($meta[self::FILE])+$meta[self::META_DELTA]<$now)||(!empty($meta[self::META_EXPIRE])&&$meta[self::META_EXPIRE]<$now)){$this->delete($path,$meta[self::HANDLE]);continue;}flock($meta[self::HANDLE],LOCK_UN);fclose($meta[self::HANDLE]);}}if($this->journal){$this->journal->clean($conditions);}return;}if($this->journal){foreach($this->journal->clean($conditions)as$file){$this->delete($file);}}}protected
function
readMetaAndLock($file,$lock){$handle=@fopen($file,'r+b');if(!$handle){return
NULL;}flock($handle,$lock);$head=stream_get_contents($handle,self::META_HEADER_LEN);if($head&&strlen($head)===self::META_HEADER_LEN){$size=(int)substr($head,-6);$meta=stream_get_contents($handle,$size,self::META_HEADER_LEN);$meta=@unserialize($meta);if(is_array($meta)){$meta[self::FILE]=$file;$meta[self::HANDLE]=$handle;return$meta;}}flock($handle,LOCK_UN);fclose($handle);return
NULL;}protected
function
readData($meta){$data=stream_get_contents($meta[self::HANDLE]);flock($meta[self::HANDLE],LOCK_UN);fclose($meta[self::HANDLE]);if(empty($meta[self::META_SERIALIZED])){return$data;}else{return@unserialize($data);}}protected
function
getCacheFile($key){$file=urlencode($key);if($this->useDirs&&$a=strrpos($file,'%00')){$file=substr_replace($file,'/_',$a,3);}return$this->dir.'/_'.$file;}private
static
function
delete($file,$handle=NULL){if(@unlink($file)){if($handle){flock($handle,LOCK_UN);fclose($handle);}return;}if(!$handle){$handle=@fopen($file,'r+');}if($handle){flock($handle,LOCK_EX);ftruncate($handle,0);flock($handle,LOCK_UN);fclose($handle);@unlink($file);}}}class
MemcachedStorage
extends
Nette\Object
implements
Nette\Caching\IStorage{const
META_CALLBACKS='callbacks',META_DATA='data',META_DELTA='delta';private$memcache;private$prefix;private$journal;static
function
isAvailable(){return
extension_loaded('memcache');}function
__construct($host='localhost',$port=11211,$prefix='',IJournal$journal=NULL){if(!static::isAvailable()){throw
new
Nette\NotSupportedException("PHP extension 'memcache' is not loaded.");}$this->prefix=$prefix;$this->journal=$journal;$this->memcache=new\Memcache;if($host){$this->addServer($host,$port);}}function
addServer($host='localhost',$port=11211,$timeout=1){if($this->memcache->addServer($host,$port,TRUE,1,$timeout)===FALSE){$error=error_get_last();throw
new
Nette\InvalidStateException("Memcache::addServer(): $error[message].");}}function
getConnection(){return$this->memcache;}function
read($key){$key=$this->prefix.$key;$meta=$this->memcache->get($key);if(!$meta){return
NULL;}if(!empty($meta[self::META_CALLBACKS])&&!Cache::checkCallbacks($meta[self::META_CALLBACKS])){$this->memcache->delete($key,0);return
NULL;}if(!empty($meta[self::META_DELTA])){$this->memcache->replace($key,$meta,0,$meta[self::META_DELTA]+time());}return$meta[self::META_DATA];}function
lock($key){}function
write($key,$data,array$dp){if(isset($dp[Cache::ITEMS])){throw
new
Nette\NotSupportedException('Dependent items are not supported by MemcachedStorage.');}$key=$this->prefix.$key;$meta=array(self::META_DATA=>$data);$expire=0;if(isset($dp[Cache::EXPIRATION])){$expire=(int)$dp[Cache::EXPIRATION];if(!empty($dp[Cache::SLIDING])){$meta[self::META_DELTA]=$expire;}}if(isset($dp[Cache::CALLBACKS])){$meta[self::META_CALLBACKS]=$dp[Cache::CALLBACKS];}if(isset($dp[Cache::TAGS])||isset($dp[Cache::PRIORITY])){if(!$this->journal){throw
new
Nette\InvalidStateException('CacheJournal has not been provided.');}$this->journal->write($key,$dp);}$this->memcache->set($key,$meta,0,$expire);}function
remove($key){$this->memcache->delete($this->prefix.$key,0);}function
clean(array$conditions){if(!empty($conditions[Cache::ALL])){$this->memcache->flush();}elseif($this->journal){foreach($this->journal->clean($conditions)as$entry){$this->memcache->delete($entry,0);}}}}class
MemoryStorage
extends
Nette\Object
implements
Nette\Caching\IStorage{private$data=array();function
read($key){return
isset($this->data[$key])?$this->data[$key]:NULL;}function
lock($key){}function
write($key,$data,array$dependencies){$this->data[$key]=$data;}function
remove($key){unset($this->data[$key]);}function
clean(array$conditions){if(!empty($conditions[Nette\Caching\Cache::ALL])){$this->data=array();}}}class
PhpFileStorage
extends
FileStorage{public$hint;protected
function
readData($meta){return
array('file'=>$meta[self::FILE],'handle'=>$meta[self::HANDLE]);}protected
function
getCacheFile($key){return
parent::getCacheFile(substr_replace($key,trim(strtr($this->hint,'\\/@','.._'),'.').'-',strpos($key,Nette\Caching\Cache::NAMESPACE_SEPARATOR)+1,0)).'.php';}}}namespace Nette{use
Nette;class
ArrayHash
extends\stdClass
implements\ArrayAccess,\Countable,\IteratorAggregate{static
function
from($arr,$recursive=TRUE){$obj=new
static;foreach($arr
as$key=>$value){if($recursive&&is_array($value)){$obj->$key=static::from($value,TRUE);}else{$obj->$key=$value;}}return$obj;}function
getIterator(){return
new\RecursiveArrayIterator($this);}function
count(){return
count((array)$this);}function
offsetSet($key,$value){if(!is_scalar($key)){throw
new
InvalidArgumentException("Key must be either a string or an integer, ".gettype($key)." given.");}$this->$key=$value;}function
offsetGet($key){return$this->$key;}function
offsetExists($key){return
isset($this->$key);}function
offsetUnset($key){unset($this->$key);}}final
class
Callback
extends
Object{private$cb;static
function
create($callback,$m=NULL){return
new
self($callback,$m);}function
__construct($cb,$m=NULL){if($m!==NULL){$cb=array($cb,$m);}elseif($cb
instanceof
self){$this->cb=$cb->cb;return;}if(!is_callable($cb,TRUE)){throw
new
InvalidArgumentException("Invalid callback.");}$this->cb=$cb;}function
__invoke(){if(!is_callable($this->cb)){throw
new
InvalidStateException("Callback '$this' is not callable.");}return
call_user_func_array($this->cb,func_get_args());}function
invoke(){if(!is_callable($this->cb)){throw
new
InvalidStateException("Callback '$this' is not callable.");}return
call_user_func_array($this->cb,func_get_args());}function
invokeArgs(array$args){if(!is_callable($this->cb)){throw
new
InvalidStateException("Callback '$this' is not callable.");}return
call_user_func_array($this->cb,$args);}function
isCallable(){return
is_callable($this->cb);}function
getNative(){return$this->cb;}function
toReflection(){if(is_string($this->cb)&&strpos($this->cb,'::')){return
new
Nette\Reflection\Method($this->cb);}elseif(is_array($this->cb)){return
new
Nette\Reflection\Method($this->cb[0],$this->cb[1]);}elseif(is_object($this->cb)&&!$this->cb
instanceof\Closure){return
new
Nette\Reflection\Method($this->cb,'__invoke');}else{return
new
Nette\Reflection\GlobalFunction($this->cb);}}function
isStatic(){return
is_array($this->cb)?is_string($this->cb[0]):is_string($this->cb);}function
bindTo($newthis){if(is_string($this->cb)&&strpos($this->cb,'::')){$this->cb=explode('::',$this->cb);}elseif(!is_array($this->cb)){throw
new
InvalidStateException("Callback '$this' have not any bound object.");}return
new
static($newthis,$this->cb[1]);}function
__toString(){if($this->cb
instanceof\Closure){return'{closure}';}elseif(is_string($this->cb)&&$this->cb[0]==="\0"){return'{lambda}';}else{is_callable($this->cb,TRUE,$textual);return$textual;}}}class
DateTime
extends\DateTime{const
MINUTE=60;const
HOUR=3600;const
DAY=86400;const
WEEK=604800;const
MONTH=2629800;const
YEAR=31557600;static
function
from($time){if($time
instanceof\DateTime){return
new
self($time->format('Y-m-d H:i:s'),$time->getTimezone());}elseif(is_numeric($time)){if($time<=self::YEAR){$time+=time();}return
new
static(date('Y-m-d H:i:s',$time));}else{return
new
static($time);}}function
__toString(){return$this->format('Y-m-d H:i:s');}function
modifyClone($modify=''){$dolly=clone$this;return$modify?$dolly->modify($modify):$dolly;}}final
class
Environment{const
DEVELOPMENT='development',PRODUCTION='production',CONSOLE='console';private
static$productionMode;private
static$createdAt;private
static$context;final
function
__construct(){throw
new
StaticClassException;}static
function
isConsole(){return
PHP_SAPI==='cli';}static
function
isProduction(){if(self::$productionMode===NULL){self::$productionMode=!Nette\Configurator::detectDebugMode();}return
self::$productionMode;}static
function
setProductionMode($value=TRUE){self::$productionMode=(bool)$value;}static
function
setVariable($name,$value,$expand=TRUE){if($expand&&is_string($value)){$value=self::getContext()->expand($value);}self::getContext()->parameters[$name]=$value;}static
function
getVariable($name,$default=NULL){if(isset(self::getContext()->parameters[$name])){return
self::getContext()->parameters[$name];}elseif(func_num_args()>1){return$default;}else{throw
new
InvalidStateException("Unknown environment variable '$name'.");}}static
function
getVariables(){return
self::getContext()->parameters;}static
function
expand($s){return
self::getContext()->expand($s);}static
function
setContext(DI\Container$context){if(self::$createdAt){throw
new
Nette\InvalidStateException('Configurator & SystemContainer has already been created automatically by Nette\Environment at '.self::$createdAt);}self::$context=$context;}static
function
getContext(){if(self::$context===NULL){self::loadConfig();}return
self::$context;}static
function
getService($name){return
self::getContext()->getService($name);}static
function
__callStatic($name,$args){if(!$args&&strncasecmp($name,'get',3)===0){return
self::getService(lcfirst(substr($name,3)));}else{throw
new
MemberAccessException("Call to undefined static method Nette\\Environment::$name().");}}static
function
getHttpRequest(){return
self::getContext()->getByType('Nette\Http\IRequest');}static
function
getHttpContext(){return
self::getContext()->getByType('Nette\Http\Context');}static
function
getHttpResponse(){return
self::getContext()->getByType('Nette\Http\IResponse');}static
function
getApplication(){return
self::getContext()->getByType('Nette\Application\Application');}static
function
getUser(){return
self::getContext()->getByType('Nette\Security\User');}static
function
getRobotLoader(){return
self::getContext()->getByType('Nette\Loaders\RobotLoader');}static
function
getCache($namespace=''){return
new
Caching\Cache(self::getService('cacheStorage'),$namespace);}static
function
getSession($namespace=NULL){return$namespace===NULL?self::getService('session'):self::getService('session')->getSection($namespace);}static
function
loadConfig($file=NULL,$section=NULL){if(self::$createdAt){throw
new
Nette\InvalidStateException('Nette\Configurator has already been created automatically by Nette\Environment at '.self::$createdAt);}elseif(!defined('TEMP_DIR')){throw
new
Nette\InvalidStateException('Nette\Environment requires constant TEMP_DIR with path to temporary directory.');}$configurator=new
Nette\Configurator;$configurator->setDebugMode(!self::isProduction())->setTempDirectory(TEMP_DIR);if($file){$configurator->addConfig($file,$section);}self::$context=$configurator->createContainer();self::$createdAt='?';foreach(debug_backtrace(FALSE)as$row){if(isset($row['file'])&&is_file($row['file'])&&strpos($row['file'],NETTE_DIR.DIRECTORY_SEPARATOR)!==0){self::$createdAt="$row[file]:$row[line]";break;}}return
self::getConfig();}static
function
getConfig($key=NULL,$default=NULL){$params=Nette\ArrayHash::from(self::getContext()->parameters);if(func_num_args()){return
isset($params[$key])?$params[$key]:$default;}else{return$params;}}}final
class
Framework{const
NAME='Nette Framework',VERSION='2.1-dev',REVISION='d301a1c released on 2013-07-11';final
function
__construct(){throw
new
StaticClassException;}}abstract
class
FreezableObject
extends
Object
implements
IFreezable{private$frozen=FALSE;function
freeze(){$this->frozen=TRUE;}final
function
isFrozen(){return$this->frozen;}function
__clone(){$this->frozen=FALSE;}protected
function
updating(){if($this->frozen){$class=get_class($this);throw
new
InvalidStateException("Cannot modify a frozen object $class.");}}}/**
 * Basic manipulation with images.
 *
 * <code>
 * $image = Image::fromFile('nette.jpg');
 * $image->resize(150, 100);
 * $image->sharpen();
 * $image->send();
 * </code>
 *
 * @author     David Grudl
 *
 * @method void alphaBlending(bool $on)
 * @method void antialias(bool $on)
 * @method void arc($x, $y, $w, $h, $s, $e, $color)
 * @method void char($font, $x, $y, $char, $color)
 * @method void charUp($font, $x, $y, $char, $color)
 * @method int colorAllocate($red, $green, $blue)
 * @method int colorAllocateAlpha($red, $green, $blue, $alpha)
 * @method int colorAt($x, $y)
 * @method int colorClosest($red, $green, $blue)
 * @method int colorClosestAlpha($red, $green, $blue, $alpha)
 * @method int colorClosestHWB($red, $green, $blue)
 * @method void colorDeallocate($color)
 * @method int colorExact($red, $green, $blue)
 * @method int colorExactAlpha($red, $green, $blue, $alpha)
 * @method void colorMatch(Image $image2)
 * @method int colorResolve($red, $green, $blue)
 * @method int colorResolveAlpha($red, $green, $blue, $alpha)
 * @method void colorSet($index, $red, $green, $blue)
 * @method array colorsForIndex($index)
 * @method int colorsTotal()
 * @method int colorTransparent([$color])
 * @method void convolution(array $matrix, float $div, float $offset)
 * @method void copy(Image $src, $dstX, $dstY, $srcX, $srcY, $srcW, $srcH)
 * @method void copyMerge(Image $src, $dstX, $dstY, $srcX, $srcY, $srcW, $srcH, $opacity)
 * @method void copyMergeGray(Image $src, $dstX, $dstY, $srcX, $srcY, $srcW, $srcH, $opacity)
 * @method void copyResampled(Image $src, $dstX, $dstY, $srcX, $srcY, $dstW, $dstH, $srcW, $srcH)
 * @method void copyResized(Image $src, $dstX, $dstY, $srcX, $srcY, $dstW, $dstH, $srcW, $srcH)
 * @method void dashedLine($x1, $y1, $x2, $y2, $color)
 * @method void ellipse($cx, $cy, $w, $h, $color)
 * @method void fill($x, $y, $color)
 * @method void filledArc($cx, $cy, $w, $h, $s, $e, $color, $style)
 * @method void filledEllipse($cx, $cy, $w, $h, $color)
 * @method void filledPolygon(array $points, $numPoints, $color)
 * @method void filledRectangle($x1, $y1, $x2, $y2, $color)
 * @method void fillToBorder($x, $y, $border, $color)
 * @method void filter($filtertype [, ...])
 * @method int fontHeight($font)
 * @method int fontWidth($font)
 * @method array ftBBox($size, $angle, string $fontFile, string $text [, array $extrainfo])
 * @method array ftText($size, $angle, $x, $y, $col, string $fontFile, string $text [, array $extrainfo])
 * @method void gammaCorrect(float $inputgamma, float $outputgamma)
 * @method int interlace([$interlace])
 * @method bool isTrueColor()
 * @method void layerEffect($effect)
 * @method void line($x1, $y1, $x2, $y2, $color)
 * @method int loadFont(string $file)
 * @method void paletteCopy(Image $source)
 * @method void polygon(array $points, $numPoints, $color)
 * @method array psBBox(string $text, $font, $size [, $space] [, $tightness] [, float $angle])
 * @method void psEncodeFont($fontIndex, string $encodingfile)
 * @method void psExtendFont($fontIndex, float $extend)
 * @method void psFreeFont($fontindex)
 * @method resource psLoadFont(string $filename)
 * @method void psSlantFont($fontIndex, float $slant)
 * @method array psText(string $text, $font, $size, $color, $backgroundColor, $x, $y [, $space] [, $tightness] [, float $angle] [, $antialiasSteps])
 * @method void rectangle($x1, $y1, $x2, $y2, $col)
 * @method Image rotate(float $angle, $backgroundColor)
 * @method void saveAlpha(bool $saveflag)
 * @method void setBrush(Image $brush)
 * @method void setPixel($x, $y, $color)
 * @method void setStyle(array $style)
 * @method void setThickness($thickness)
 * @method void setTile(Image $tile)
 * @method void string($font, $x, $y, string $s, $col)
 * @method void stringUp($font, $x, $y, string $s, $col)
 * @method void trueColorToPalette(bool $dither, $ncolors)
 * @method array ttfBBox($size, $angle, string $fontfile, string $text)
 * @method array ttfText($size, $angle, $x, $y, $color, string $fontfile, string $text)
 * @method int types()
 * @property-read int $width
 * @property-read int $height
 * @property-read resource $imageResource
 */class
Image
extends
Object{const
SHRINK_ONLY=1;const
STRETCH=2;const
FIT=0;const
FILL=4;const
EXACT=8;const
JPEG=IMAGETYPE_JPEG,PNG=IMAGETYPE_PNG,GIF=IMAGETYPE_GIF;const
EMPTY_GIF="GIF89a\x01\x00\x01\x00\x80\x00\x00\x00\x00\x00\x00\x00\x00!\xf9\x04\x01\x00\x00\x00\x00,\x00\x00\x00\x00\x01\x00\x01\x00\x00\x02\x02D\x01\x00;";const
ENLARGE=0;private$image;static
function
rgb($red,$green,$blue,$transparency=0){return
array('red'=>max(0,min(255,(int)$red)),'green'=>max(0,min(255,(int)$green)),'blue'=>max(0,min(255,(int)$blue)),'alpha'=>max(0,min(127,(int)$transparency)));}static
function
fromFile($file,&$format=NULL){if(!extension_loaded('gd')){throw
new
NotSupportedException("PHP extension GD is not loaded.");}$info=@getimagesize($file);switch($format=$info[2]){case
self::JPEG:return
new
static(imagecreatefromjpeg($file));case
self::PNG:return
new
static(imagecreatefrompng($file));case
self::GIF:return
new
static(imagecreatefromgif($file));default:throw
new
UnknownImageFileException("Unknown image type or file '$file' not found.");}}static
function
getFormatFromString($s){$types=array('image/jpeg'=>self::JPEG,'image/gif'=>self::GIF,'image/png'=>self::PNG);$type=Utils\MimeTypeDetector::fromString($s);return
isset($types[$type])?$types[$type]:NULL;}static
function
fromString($s,&$format=NULL){if(!extension_loaded('gd')){throw
new
NotSupportedException("PHP extension GD is not loaded.");}$format=static::getFormatFromString($s);return
new
static(imagecreatefromstring($s));}static
function
fromBlank($width,$height,$color=NULL){if(!extension_loaded('gd')){throw
new
NotSupportedException("PHP extension GD is not loaded.");}$width=(int)$width;$height=(int)$height;if($width<1||$height<1){throw
new
InvalidArgumentException('Image width and height must be greater than zero.');}$image=imagecreatetruecolor($width,$height);if(is_array($color)){$color+=array('alpha'=>0);$color=imagecolorallocatealpha($image,$color['red'],$color['green'],$color['blue'],$color['alpha']);imagealphablending($image,FALSE);imagefilledrectangle($image,0,0,$width-1,$height-1,$color);imagealphablending($image,TRUE);}return
new
static($image);}function
__construct($image){$this->setImageResource($image);imagesavealpha($image,TRUE);}function
getWidth(){return
imagesx($this->image);}function
getHeight(){return
imagesy($this->image);}protected
function
setImageResource($image){if(!is_resource($image)||get_resource_type($image)!=='gd'){throw
new
InvalidArgumentException('Image is not valid.');}$this->image=$image;return$this;}function
getImageResource(){return$this->image;}function
resize($width,$height,$flags=self::FIT){if($flags&self::EXACT){return$this->resize($width,$height,self::FILL)->crop('50%','50%',$width,$height);}list($newWidth,$newHeight)=static::calculateSize($this->getWidth(),$this->getHeight(),$width,$height,$flags);if($newWidth!==$this->getWidth()||$newHeight!==$this->getHeight()){$newImage=static::fromBlank($newWidth,$newHeight,self::RGB(0,0,0,127))->getImageResource();imagecopyresampled($newImage,$this->getImageResource(),0,0,0,0,$newWidth,$newHeight,$this->getWidth(),$this->getHeight());$this->image=$newImage;}if($width<0||$height<0){$newImage=static::fromBlank($newWidth,$newHeight,self::RGB(0,0,0,127))->getImageResource();imagecopyresampled($newImage,$this->getImageResource(),0,0,$width<0?$newWidth-1:0,$height<0?$newHeight-1:0,$newWidth,$newHeight,$width<0?-$newWidth:$newWidth,$height<0?-$newHeight:$newHeight);$this->image=$newImage;}return$this;}static
function
calculateSize($srcWidth,$srcHeight,$newWidth,$newHeight,$flags=self::FIT){if(substr($newWidth,-1)==='%'){$newWidth=round($srcWidth/100*abs($newWidth));$percents=TRUE;}else{$newWidth=(int)abs($newWidth);}if(substr($newHeight,-1)==='%'){$newHeight=round($srcHeight/100*abs($newHeight));$flags|=empty($percents)?0:self::STRETCH;}else{$newHeight=(int)abs($newHeight);}if($flags&self::STRETCH){if(empty($newWidth)||empty($newHeight)){throw
new
InvalidArgumentException('For stretching must be both width and height specified.');}if($flags&self::SHRINK_ONLY){$newWidth=round($srcWidth*min(1,$newWidth/$srcWidth));$newHeight=round($srcHeight*min(1,$newHeight/$srcHeight));}}else{if(empty($newWidth)&&empty($newHeight)){throw
new
InvalidArgumentException('At least width or height must be specified.');}$scale=array();if($newWidth>0){$scale[]=$newWidth/$srcWidth;}if($newHeight>0){$scale[]=$newHeight/$srcHeight;}if($flags&self::FILL){$scale=array(max($scale));}if($flags&self::SHRINK_ONLY){$scale[]=1;}$scale=min($scale);$newWidth=round($srcWidth*$scale);$newHeight=round($srcHeight*$scale);}return
array(max((int)$newWidth,1),max((int)$newHeight,1));}function
crop($left,$top,$width,$height){list($left,$top,$width,$height)=static::calculateCutout($this->getWidth(),$this->getHeight(),$left,$top,$width,$height);$newImage=static::fromBlank($width,$height,self::RGB(0,0,0,127))->getImageResource();imagecopy($newImage,$this->getImageResource(),0,0,$left,$top,$width,$height);$this->image=$newImage;return$this;}static
function
calculateCutout($srcWidth,$srcHeight,$left,$top,$newWidth,$newHeight){if(substr($newWidth,-1)==='%'){$newWidth=round($srcWidth/100*$newWidth);}if(substr($newHeight,-1)==='%'){$newHeight=round($srcHeight/100*$newHeight);}if(substr($left,-1)==='%'){$left=round(($srcWidth-$newWidth)/100*$left);}if(substr($top,-1)==='%'){$top=round(($srcHeight-$newHeight)/100*$top);}if($left<0){$newWidth+=$left;$left=0;}if($top<0){$newHeight+=$top;$top=0;}$newWidth=min((int)$newWidth,$srcWidth-$left);$newHeight=min((int)$newHeight,$srcHeight-$top);return
array($left,$top,$newWidth,$newHeight);}function
sharpen(){imageconvolution($this->getImageResource(),array(array(-1,-1,-1),array(-1,24,-1),array(-1,-1,-1)),16,0);return$this;}function
place(Image$image,$left=0,$top=0,$opacity=100){$opacity=max(0,min(100,(int)$opacity));if(substr($left,-1)==='%'){$left=round(($this->getWidth()-$image->getWidth())/100*$left);}if(substr($top,-1)==='%'){$top=round(($this->getHeight()-$image->getHeight())/100*$top);}if($opacity===100){imagecopy($this->getImageResource(),$image->getImageResource(),$left,$top,0,0,$image->getWidth(),$image->getHeight());}elseif($opacity<>0){imagecopymerge($this->getImageResource(),$image->getImageResource(),$left,$top,0,0,$image->getWidth(),$image->getHeight(),$opacity);}return$this;}function
save($file=NULL,$quality=NULL,$type=NULL){if($type===NULL){switch(strtolower(pathinfo($file,PATHINFO_EXTENSION))){case'jpg':case'jpeg':$type=self::JPEG;break;case'png':$type=self::PNG;break;case'gif':$type=self::GIF;}}switch($type){case
self::JPEG:$quality=$quality===NULL?85:max(0,min(100,(int)$quality));return
imagejpeg($this->getImageResource(),$file,$quality);case
self::PNG:$quality=$quality===NULL?9:max(0,min(9,(int)$quality));return
imagepng($this->getImageResource(),$file,$quality);case
self::GIF:return
imagegif($this->getImageResource(),$file);default:throw
new
InvalidArgumentException("Unsupported image type.");}}function
toString($type=self::JPEG,$quality=NULL){ob_start();$this->save(NULL,$quality,$type);return
ob_get_clean();}function
__toString(){try{return$this->toString();}catch(\Exception$e){trigger_error("Exception in ".__METHOD__."(): {$e->getMessage()} in {$e->getFile()}:{$e->getLine()}",E_USER_ERROR);}}function
send($type=self::JPEG,$quality=NULL){if($type!==self::GIF&&$type!==self::PNG&&$type!==self::JPEG){throw
new
InvalidArgumentException("Unsupported image type.");}header('Content-Type: '.image_type_to_mime_type($type));return$this->save(NULL,$quality,$type);}function
__call($name,$args){$function='image'.$name;if(function_exists($function)){foreach($args
as$key=>$value){if($value
instanceof
self){$args[$key]=$value->getImageResource();}elseif(is_array($value)&&isset($value['red'])){$args[$key]=imagecolorallocatealpha($this->getImageResource(),$value['red'],$value['green'],$value['blue'],$value['alpha']);}}array_unshift($args,$this->getImageResource());$res=call_user_func_array($function,$args);return
is_resource($res)&&get_resource_type($res)==='gd'?$this->setImageResource($res):$res;}return
parent::__call($name,$args);}}class
UnknownImageFileException
extends\Exception{}final
class
ObjectMixin{private
static$methods;private
static$props;private
static$extMethods;final
function
__construct(){throw
new
StaticClassException;}static
function
call($_this,$name,$args){$class=get_class($_this);$isProp=self::hasProperty($class,$name);$methods=&self::getMethods($class);if($name===''){throw
new
MemberAccessException("Call to class '$class' method without name.");}elseif($isProp&&$_this->$name
instanceof\Closure){return
call_user_func_array($_this->$name,$args);}elseif($isProp==='event'){if(is_array($_this->$name)||$_this->$name
instanceof\Traversable){foreach($_this->$name
as$handler){Nette\Utils\Callback::invokeArgs($handler,$args);}}elseif($_this->$name!==NULL){throw
new
UnexpectedValueException("Property $class::$$name must be array or NULL, ".gettype($_this->$name)." given.");}}elseif(isset($methods[$name])){list($op,$rp,$type)=$methods[$name];if(!$rp){throw
new
MemberAccessException("Magic method $class::$name() has not corresponding property $$op.");}elseif(count($args)!==($op==='get'?0:1)){throw
new
InvalidArgumentException("$class::$name() expects ".($op==='get'?'no':'1').' argument, '.count($args).' given.');}elseif($type&&$args&&!self::checkType($args[0],$type)){throw
new
InvalidArgumentException("Argument passed to $class::$name() must be $type, ".gettype($args[0]).' given.');}if($op==='get'){return$rp->getValue($_this);}elseif($op==='set'){$rp->setValue($_this,$args[0]);}elseif($op==='add'){$val=$rp->getValue($_this);$val[]=$args[0];$rp->setValue($_this,$val);}return$_this;}elseif($cb=self::getExtensionMethod($class,$name)){array_unshift($args,$_this);return
Nette\Utils\Callback::invokeArgs($cb,$args);}else{throw
new
MemberAccessException("Call to undefined method $class::$name().");}}static
function
callStatic($class,$method,$args){throw
new
MemberAccessException("Call to undefined static method $class::$method().");}static
function&get($_this,$name){$class=get_class($_this);$uname=ucfirst($name);$methods=&self::getMethods($class);if($name===''){throw
new
MemberAccessException("Cannot read a class '$class' property without name.");}elseif(isset($methods[$m='get'.$uname])||isset($methods[$m='is'.$uname])){if($methods[$m]===0){$rm=new\ReflectionMethod($class,$m);$methods[$m]=$rm->returnsReference();}if($methods[$m]===TRUE){return$_this->$m();}else{$val=$_this->$m();return$val;}}elseif(isset($methods[$name])){if(PHP_VERSION_ID>=50400){$rm=new\ReflectionMethod($class,$name);$val=$rm->getClosure($_this);}else{$val=Nette\Utils\Callback::closure($_this,$name);}return$val;}else{$type=isset($methods['set'.$uname])?'a write-only':'an undeclared';throw
new
MemberAccessException("Cannot read $type property $class::\$$name.");}}static
function
set($_this,$name,$value){$class=get_class($_this);$uname=ucfirst($name);$methods=&self::getMethods($class);if($name===''){throw
new
MemberAccessException("Cannot write to a class '$class' property without name.");}elseif(self::hasProperty($class,$name)){$_this->$name=$value;}elseif(isset($methods[$m='set'.$uname])){$_this->$m($value);}else{$type=isset($methods['get'.$uname])||isset($methods['is'.$uname])?'a read-only':'an undeclared';throw
new
MemberAccessException("Cannot write to $type property $class::\$$name.");}}static
function
remove($_this,$name){$class=get_class($_this);if(!self::hasProperty($class,$name)){throw
new
MemberAccessException("Cannot unset the property $class::\$$name.");}}static
function
has($_this,$name){$name=ucfirst($name);$methods=&self::getMethods(get_class($_this));return$name!==''&&(isset($methods['get'.$name])||isset($methods['is'.$name]));}private
static
function
hasProperty($class,$name){$prop=&self::$props[$class][$name];if($prop===NULL){$prop=FALSE;try{$rp=new\ReflectionProperty($class,$name);if($rp->isPublic()&&!$rp->isStatic()){$prop=preg_match('#^on[A-Z]#',$name)?'event':TRUE;}}catch(\ReflectionException$e){}}return$prop;}private
static
function&getMethods($class){if(!isset(self::$methods[$class])){self::$methods[$class]=array_fill_keys(get_class_methods($class),0)+self::getMagicMethods($class);if($parent=get_parent_class($class)){self::$methods[$class]+=self::getMethods($parent);}}return
self::$methods[$class];}/**
	 * Returns array of magic methods defined by annotation @method.
	 * @return array
	 */static
function
getMagicMethods($class){$rc=new\ReflectionClass($class);preg_match_all('~^
			[ \t*]*  @method  [ \t]+
			(?: [^\s(]+  [ \t]+ )?
			(set|get|is|add)  ([A-Z]\w*)  [ \t]*
			(?: \(  [ \t]* ([^)$\s]+)  )?
		()~mx',$rc->getDocComment(),$matches,PREG_SET_ORDER);$methods=array();foreach($matches
as$m){list(,$op,$prop,$type)=$m;$name=$op.$prop;$prop=strtolower($prop[0]).substr($prop,1).($op==='add'?'s':'');if($rc->hasProperty($prop)&&($rp=$rc->getProperty($prop))&&!$rp->isStatic()){$rp->setAccessible(TRUE);if($op==='get'||$op==='is'){$type=NULL;$op='get';}elseif(!$type&&preg_match('#@var[ \t]+(\S+)'.($op==='add'?'\[\]#':'#'),$rp->getDocComment(),$m)){$type=$m[1];}if($rc->inNamespace()&&preg_match('#^[A-Z]\w+(\[|\||\z)#',$type)){$type=$rc->getNamespaceName().'\\'.$type;}$methods[$name]=array($op,$rp,$type);}else{$methods[$name]=array($prop,NULL,NULL);}}return$methods;}static
function
checkType(&$val,$type){if(strpos($type,'|')!==FALSE){$found=NULL;foreach(explode('|',$type)as$type){$tmp=$val;if(self::checkType($tmp,$type)){if($val===$tmp){return
TRUE;}$found[]=$tmp;}}if($found){$val=$found[0];return
TRUE;}return
FALSE;}elseif(substr($type,-2)==='[]'){if(!is_array($val)){return
FALSE;}$type=substr($type,0,-2);$res=array();foreach($val
as$k=>$v){if(!self::checkType($v,$type)){return
FALSE;}$res[$k]=$v;}$val=$res;return
TRUE;}switch(strtolower($type)){case
NULL:case'mixed':return
TRUE;case'bool':case'boolean':return($val===NULL||is_scalar($val))&&settype($val,'bool');case'string':return($val===NULL||is_scalar($val)||(is_object($val)&&method_exists($val,'__toString')))&&settype($val,'string');case'int':case'integer':return($val===NULL||is_bool($val)||is_numeric($val))&&((float)(int)$val===(float)$val)&&settype($val,'int');case'float':return($val===NULL||is_bool($val)||is_numeric($val))&&settype($val,'float');case'scalar':case'array':case'object':case'callable':case'resource':case'null':return
call_user_func("is_$type",$val);default:return$val
instanceof$type;}}static
function
setExtensionMethod($class,$name,$callback){$name=strtolower($name);self::$extMethods[$name][$class]=Nette\Utils\Callback::closure($callback);self::$extMethods[$name]['']=NULL;}static
function
getExtensionMethod($class,$name){$list=&self::$extMethods[strtolower($name)];$cache=&$list[''][$class];if(isset($cache)){return$cache;}foreach(array($class)+class_parents($class)+class_implements($class)as$cl){if(isset($list[$cl])){return$cache=$list[$cl];}}return$cache=FALSE;}}}namespace Nette\ComponentModel{use
Nette;class
RecursiveComponentIterator
extends\RecursiveArrayIterator
implements\Countable{function
hasChildren(){return$this->current()instanceof
IContainer;}function
getChildren(){return$this->current()->getComponents();}function
count(){return
iterator_count($this);}}}namespace Nette\Database{use
Nette;use
Nette\ObjectMixin;use
PDO;class
Connection
extends
Nette\Object{private$params;private$options;private$driver;private$preprocessor;private$selectionFactory;private$pdo;public$onConnect;public$onQuery;function
__construct($dsn,$user=NULL,$password=NULL,array$options=NULL){if(func_num_args()>4){$options['driverClass']=func_get_arg(4);}$this->params=array($dsn,$user,$password);$this->options=(array)$options;if(empty($options['lazy'])){$this->connect();}}private
function
connect(){if($this->pdo){return;}$this->pdo=new
PDO($this->params[0],$this->params[1],$this->params[2],$this->options);$this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);$class=empty($this->options['driverClass'])?'Nette\Database\Drivers\\'.ucfirst(str_replace('sql','Sql',$this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME))).'Driver':$this->options['driverClass'];$this->driver=new$class($this,$this->options);$this->preprocessor=new
SqlPreprocessor($this);$this->onConnect($this);}function
getDsn(){return$this->params[0];}function
getPdo(){$this->connect();return$this->pdo;}function
getSupplementalDriver(){$this->connect();return$this->driver;}function
beginTransaction(){$this->queryArgs('::beginTransaction',array());}function
commit(){$this->queryArgs('::commit',array());}function
rollBack(){$this->queryArgs('::rollBack',array());}function
getInsertId($name=NULL){return$this->getPdo()->lastInsertId($name);}function
quote($string,$type=PDO::PARAM_STR){return$this->getPdo()->quote($string,$type);}function
query($statement){$args=func_get_args();return$this->queryArgs(array_shift($args),$args);}function
queryArgs($statement,array$params){$this->connect();if($params){array_unshift($params,$statement);list($statement,$params)=$this->preprocessor->process($params);}try{$result=new
ResultSet($this,$statement,$params);}catch(\PDOException$e){$e->queryString=$statement;$this->onQuery($this,$e);throw$e;}$this->onQuery($this,$result);return$result;}function
fetch($args){$args=func_get_args();return$this->queryArgs(array_shift($args),$args)->fetch();}function
fetchField($args){$args=func_get_args();return$this->queryArgs(array_shift($args),$args)->fetchField();}function
fetchPairs($args){$args=func_get_args();return$this->queryArgs(array_shift($args),$args)->fetchPairs(0,1);}function
fetchAll($args){$args=func_get_args();return$this->queryArgs(array_shift($args),$args)->fetchAll();}static
function
literal($value){$args=func_get_args();return
new
SqlLiteral(array_shift($args),$args);}function
table($table){trigger_error(__METHOD__.'() is deprecated; use SelectionFactory::table() instead.',E_USER_DEPRECATED);if(!$this->selectionFactory){$this->selectionFactory=new
SelectionFactory($this);}return$this->selectionFactory->table($table);}function
setSelectionFactory(SelectionFactory$selectionFactory){$this->selectionFactory=$selectionFactory;return$this;}function
getSelectionFactory(){return$this->selectionFactory;}function
setDatabaseReflection(){trigger_error(__METHOD__.'() is deprecated; use setSelectionFactory() instead.',E_USER_DEPRECATED);return$this;}function
setCacheStorage(){trigger_error(__METHOD__.'() is deprecated; use setSelectionFactory() instead.',E_USER_DEPRECATED);}function
lastInsertId($name=NULL){trigger_error(__METHOD__.'() is deprecated; use getInsertId() instead.',E_USER_DEPRECATED);return$this->getInsertId($name);}function
exec($statement){trigger_error(__METHOD__.'() is deprecated; use query()->getRowCount() instead.',E_USER_DEPRECATED);$args=func_get_args();return$this->queryArgs(array_shift($args),$args)->getRowCount();}}}namespace Nette\Database\Diagnostics{use
Nette;use
Nette\Database\Helpers;use
Nette\Diagnostics\Debugger;class
ConnectionPanel
extends
Nette\Object
implements
Nette\Diagnostics\IBarPanel{static
public$maxLength;private$totalTime=0;private$queries=array();public$name;public$explain=TRUE;public$disabled=FALSE;function
__construct(Nette\Database\Connection$connection){$connection->onQuery[]=array($this,'logQuery');}function
logQuery(Nette\Database\Connection$connection,$result){if($this->disabled){return;}$source=NULL;$trace=$result
instanceof\PDOException?$result->getTrace():debug_backtrace(PHP_VERSION_ID>=50306?DEBUG_BACKTRACE_IGNORE_ARGS:FALSE);foreach($trace
as$row){if(isset($row['file'])&&is_file($row['file'])&&strpos($row['file'],NETTE_DIR.DIRECTORY_SEPARATOR)!==0){if(isset($row['function'])&&strpos($row['function'],'call_user_func')===0)continue;if(isset($row['class'])&&is_subclass_of($row['class'],'\\Nette\\Database\\Connection'))continue;$source=array($row['file'],(int)$row['line']);break;}}if($result
instanceof
Nette\Database\ResultSet){$this->totalTime+=$result->getTime();$this->queries[]=array($connection,$result->getQueryString(),$result->getParameters(),$source,$result->getTime(),$result->getRowCount(),NULL);}elseif($result
instanceof\PDOException){$this->queries[]=array($connection,$result->queryString,NULL,$source,NULL,NULL,$result->getMessage());}}static
function
renderException($e){if(!$e
instanceof\PDOException){return;}if(isset($e->queryString)){$sql=$e->queryString;}elseif($item=Nette\Diagnostics\Helpers::findTrace($e->getTrace(),'PDO::prepare')){$sql=$item['args'][0];}return
isset($sql)?array('tab'=>'SQL','panel'=>Helpers::dumpSql($sql)):NULL;}function
getTab(){return'<span title="Nette\\Database '.htmlSpecialChars($this->name).'">'.'<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAQAAAC1+jfqAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAEYSURBVBgZBcHPio5hGAfg6/2+R980k6wmJgsJ5U/ZOAqbSc2GnXOwUg7BESgLUeIQ1GSjLFnMwsKGGg1qxJRmPM97/1zXFAAAAEADdlfZzr26miup2svnelq7d2aYgt3rebl585wN6+K3I1/9fJe7O/uIePP2SypJkiRJ0vMhr55FLCA3zgIAOK9uQ4MS361ZOSX+OrTvkgINSjS/HIvhjxNNFGgQsbSmabohKDNoUGLohsls6BaiQIMSs2FYmnXdUsygQYmumy3Nhi6igwalDEOJEjPKP7CA2aFNK8Bkyy3fdNCg7r9/fW3jgpVJbDmy5+PB2IYp4MXFelQ7izPrhkPHB+P5/PjhD5gCgCenx+VR/dODEwD+A3T7nqbxwf1HAAAAAElFTkSuQmCC" />'.count($this->queries).' '.(count($this->queries)===1?'query':'queries').($this->totalTime?' / '.sprintf('%0.1f',$this->totalTime*1000).'ms':'').'</span>';}function
getPanel(){$this->disabled=TRUE;$s='';foreach($this->queries
as$i=>$query){list($connection,$sql,$params,$source,$time,$rows,$error)=$query;$explain=NULL;if(!$error&&$this->explain&&preg_match('#\s*\(?\s*SELECT\s#iA',$sql)){try{$cmd=is_string($this->explain)?$this->explain:'EXPLAIN';$explain=$connection->queryArgs("$cmd $sql",$params)->fetchAll();}catch(\PDOException$e){}}$s.='<tr><td>';if($error){$s.='<span title="'.htmlSpecialChars($error,ENT_IGNORE|ENT_QUOTES).'">ERROR</span>';}elseif($time!==NULL){$s.=sprintf('%0.3f',$time*1000);}if($explain){static$counter;$counter++;$s.="<br /><a class='nette-toggle-collapsed' href='#nette-DbConnectionPanel-row-$counter'>explain</a>";}$s.='</td><td class="nette-DbConnectionPanel-sql">'.Helpers::dumpSql($sql,$params);if($explain){$s.="<table id='nette-DbConnectionPanel-row-$counter' class='nette-collapsed'><tr>";foreach($explain[0]as$col=>$foo){$s.='<th>'.htmlSpecialChars($col).'</th>';}$s.="</tr>";foreach($explain
as$row){$s.="<tr>";foreach($row
as$col){$s.='<td>'.htmlSpecialChars($col).'</td>';}$s.="</tr>";}$s.="</table>";}if($source){$s.=Nette\Diagnostics\Helpers::editorLink($source[0],$source[1])->class('nette-DbConnectionPanel-source');}$s.='</td><td>'.$rows.'</td></tr>';}return
empty($this->queries)?'':'<style class="nette-debug"> #nette-debug td.nette-DbConnectionPanel-sql { background: white !important }
			#nette-debug .nette-DbConnectionPanel-source { color: #BBB !important } </style>
			<h1 title="'.htmlSpecialChars($connection->getDsn()).'">Queries: '.count($this->queries).($this->totalTime?', time: '.sprintf('%0.3f',$this->totalTime*1000).' ms':'').', '.htmlSpecialChars($this->name).'</h1>
			<div class="nette-inner nette-DbConnectionPanel">
			<table>
				<tr><th>Time&nbsp;ms</th><th>SQL Query</th><th>Rows</th></tr>'.$s.'
			</table>
			</div>';}}}namespace Nette\Database\Drivers{use
Nette;class
MsSqlDriver
extends
Nette\Object
implements
Nette\Database\ISupplementalDriver{private$connection;function
__construct(Nette\Database\Connection$connection,array$options){$this->connection=$connection;}function
delimite($name){return'['.str_replace(array('[',']'),array('[[',']]'),$name).']';}function
formatBool($value){return$value?'1':'0';}function
formatDateTime(\DateTime$value){return$value->format("'Y-m-d H:i:s'");}function
formatLike($value,$pos){$value=strtr($value,array("'"=>"''",'%'=>'[%]','_'=>'[_]','['=>'[[]'));return($pos<=0?"'%":"'").$value.($pos>=0?"%'":"'");}function
applyLimit(&$sql,$limit,$offset){if($limit>=0){$sql=preg_replace('#^\s*(SELECT|UPDATE|DELETE)#i','$0 TOP '.(int)$limit,$sql,1,$count);if(!$count){throw
new
Nette\InvalidArgumentException('SQL query must begin with SELECT, UPDATE or DELETE command.');}}if($offset){throw
new
Nette\NotSupportedException('Offset is not supported by this database.');}}function
normalizeRow($row){return$row;}function
getTables(){throw
new
Nette\NotImplementedException;}function
getColumns($table){throw
new
Nette\NotImplementedException;}function
getIndexes($table){throw
new
Nette\NotImplementedException;}function
getForeignKeys($table){throw
new
Nette\NotImplementedException;}function
getColumnTypes(\PDOStatement$statement){return
Nette\Database\Helpers::detectTypes($statement);}function
isSupported($item){return$item===self::SUPPORT_SUBSELECT;}}class
MySqlDriver
extends
Nette\Object
implements
Nette\Database\ISupplementalDriver{const
ERROR_ACCESS_DENIED=1045;const
ERROR_DUPLICATE_ENTRY=1062;const
ERROR_DATA_TRUNCATED=1265;private$connection;function
__construct(Nette\Database\Connection$connection,array$options){$this->connection=$connection;$charset=isset($options['charset'])?$options['charset']:'utf8';if($charset){$connection->query("SET NAMES '$charset'");}if(isset($options['sqlmode'])){$connection->query("SET sql_mode='$options[sqlmode]'");}}function
delimite($name){return'`'.str_replace('`','``',$name).'`';}function
formatBool($value){return$value?'1':'0';}function
formatDateTime(\DateTime$value){return$value->format("'Y-m-d H:i:s'");}function
formatLike($value,$pos){$value=addcslashes(str_replace('\\','\\\\',$value),"\x00\n\r\\'%_");return($pos<=0?"'%":"'").$value.($pos>=0?"%'":"'");}function
applyLimit(&$sql,$limit,$offset){if($limit>=0||$offset>0){$sql.=' LIMIT '.($limit<0?'18446744073709551615':(int)$limit).($offset>0?' OFFSET '.(int)$offset:'');}}function
normalizeRow($row){return$row;}function
getTables(){$tables=array();foreach($this->connection->query('SHOW FULL TABLES')as$row){$tables[]=array('name'=>$row[0],'view'=>isset($row[1])&&$row[1]==='VIEW');}return$tables;}function
getColumns($table){$columns=array();foreach($this->connection->query('SHOW FULL COLUMNS FROM '.$this->delimite($table))as$row){$type=explode('(',$row['Type']);$columns[]=array('name'=>$row['Field'],'table'=>$table,'nativetype'=>strtoupper($type[0]),'size'=>isset($type[1])?(int)$type[1]:NULL,'unsigned'=>(bool)strstr($row['Type'],'unsigned'),'nullable'=>$row['Null']==='YES','default'=>$row['Default'],'autoincrement'=>$row['Extra']==='auto_increment','primary'=>$row['Key']==='PRI','vendor'=>(array)$row);}return$columns;}function
getIndexes($table){$indexes=array();foreach($this->connection->query('SHOW INDEX FROM '.$this->delimite($table))as$row){$indexes[$row['Key_name']]['name']=$row['Key_name'];$indexes[$row['Key_name']]['unique']=!$row['Non_unique'];$indexes[$row['Key_name']]['primary']=$row['Key_name']==='PRIMARY';$indexes[$row['Key_name']]['columns'][$row['Seq_in_index']-1]=$row['Column_name'];}return
array_values($indexes);}function
getForeignKeys($table){$keys=array();$query='SELECT CONSTRAINT_NAME, COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME FROM information_schema.KEY_COLUMN_USAGE '.'WHERE TABLE_SCHEMA = DATABASE() AND REFERENCED_TABLE_NAME IS NOT NULL AND TABLE_NAME = '.$this->connection->quote($table);foreach($this->connection->query($query)as$id=>$row){$keys[$id]['name']=$row['CONSTRAINT_NAME'];$keys[$id]['local']=$row['COLUMN_NAME'];$keys[$id]['table']=$row['REFERENCED_TABLE_NAME'];$keys[$id]['foreign']=$row['REFERENCED_COLUMN_NAME'];}return
array_values($keys);}function
getColumnTypes(\PDOStatement$statement){return
Nette\Database\Helpers::detectTypes($statement);}function
isSupported($item){return$item===self::SUPPORT_SELECT_UNGROUPED_COLUMNS;}}class
OciDriver
extends
Nette\Object
implements
Nette\Database\ISupplementalDriver{private$connection;private$fmtDateTime;function
__construct(Nette\Database\Connection$connection,array$options){$this->connection=$connection;$this->fmtDateTime=isset($options['formatDateTime'])?$options['formatDateTime']:'U';}function
delimite($name){return'"'.str_replace('"','""',$name).'"';}function
formatBool($value){return$value?'1':'0';}function
formatDateTime(\DateTime$value){return$value->format($this->fmtDateTime);}function
formatLike($value,$pos){throw
new
Nette\NotImplementedException;}function
applyLimit(&$sql,$limit,$offset){if($offset>0){$sql='SELECT * FROM (SELECT t.*, ROWNUM AS "__rnum" FROM ('.$sql.') t '.($limit>=0?'WHERE ROWNUM <= '.((int)$offset+(int)$limit):'').') WHERE "__rnum" > '.(int)$offset;}elseif($limit>=0){$sql='SELECT * FROM ('.$sql.') WHERE ROWNUM <= '.(int)$limit;}}function
normalizeRow($row){return$row;}function
getTables(){$tables=array();foreach($this->connection->query('SELECT * FROM cat')as$row){if($row[1]==='TABLE'||$row[1]==='VIEW'){$tables[]=array('name'=>$row[0],'view'=>$row[1]==='VIEW');}}return$tables;}function
getColumns($table){throw
new
Nette\NotImplementedException;}function
getIndexes($table){throw
new
Nette\NotImplementedException;}function
getForeignKeys($table){throw
new
Nette\NotImplementedException;}function
getColumnTypes(\PDOStatement$statement){return
Nette\Database\Helpers::detectTypes($statement);}function
isSupported($item){return$item===self::SUPPORT_SEQUENCE||$item===self::SUPPORT_SUBSELECT;}}class
OdbcDriver
extends
Nette\Object
implements
Nette\Database\ISupplementalDriver{private$connection;function
__construct(Nette\Database\Connection$connection,array$options){$this->connection=$connection;}function
delimite($name){return'['.str_replace(array('[',']'),array('[[',']]'),$name).']';}function
formatBool($value){return$value?'1':'0';}function
formatDateTime(\DateTime$value){return$value->format("#m/d/Y H:i:s#");}function
formatLike($value,$pos){$value=strtr($value,array("'"=>"''",'%'=>'[%]','_'=>'[_]','['=>'[[]'));return($pos<=0?"'%":"'").$value.($pos>=0?"%'":"'");}function
applyLimit(&$sql,$limit,$offset){if($limit>=0){$sql=preg_replace('#^\s*(SELECT|UPDATE|DELETE)#i','$0 TOP '.(int)$limit,$sql,1,$count);if(!$count){throw
new
Nette\InvalidArgumentException('SQL query must begin with SELECT, UPDATE or DELETE command.');}}if($offset){throw
new
Nette\NotSupportedException('Offset is not supported by this database.');}}function
normalizeRow($row){return$row;}function
getTables(){throw
new
Nette\NotImplementedException;}function
getColumns($table){throw
new
Nette\NotImplementedException;}function
getIndexes($table){throw
new
Nette\NotImplementedException;}function
getForeignKeys($table){throw
new
Nette\NotImplementedException;}function
getColumnTypes(\PDOStatement$statement){return
Nette\Database\Helpers::detectTypes($statement);}function
isSupported($item){return$item===self::SUPPORT_SUBSELECT;}}class
PgSqlDriver
extends
Nette\Object
implements
Nette\Database\ISupplementalDriver{private$connection;function
__construct(Nette\Database\Connection$connection,array$options){$this->connection=$connection;}function
delimite($name){return'"'.str_replace('"','""',$name).'"';}function
formatBool($value){return$value?'TRUE':'FALSE';}function
formatDateTime(\DateTime$value){return$value->format("'Y-m-d H:i:s'");}function
formatLike($value,$pos){$value=strtr($value,array("'"=>"''",'\\'=>'\\\\','%'=>'\\\\%','_'=>'\\\\_'));return($pos<=0?"'%":"'").$value.($pos>=0?"%'":"'");}function
applyLimit(&$sql,$limit,$offset){if($limit>=0){$sql.=' LIMIT '.(int)$limit;}if($offset>0){$sql.=' OFFSET '.(int)$offset;}}function
normalizeRow($row){return$row;}function
getTables(){$tables=array();foreach($this->connection->query("
			SELECT
				c.relname::varchar AS name,
				c.relkind = 'v' AS view
			FROM
				pg_catalog.pg_class AS c
				JOIN pg_catalog.pg_namespace AS n ON n.oid = c.relnamespace
			WHERE
				c.relkind IN ('r', 'v')
				AND n.nspname = current_schema()
			ORDER BY
				c.relname
		")as$row){$tables[]=(array)$row;}return$tables;}function
getColumns($table){$columns=array();foreach($this->connection->query("
			SELECT
				a.attname::varchar AS name,
				c.relname::varchar AS table,
				upper(t.typname) AS nativetype,
				NULL AS size,
				FALSE AS unsigned,
				NOT (a.attnotnull OR t.typtype = 'd' AND t.typnotnull) AS nullable,
				ad.adsrc::varchar AS default,
				coalesce(co.contype = 'p' AND strpos(ad.adsrc, 'nextval') = 1, FALSE) AS autoincrement,
				coalesce(co.contype = 'p', FALSE) AS primary,
				substring(ad.adsrc from 'nextval[(]''\"?([^''\"]+)') AS sequence
			FROM
				pg_catalog.pg_attribute AS a
				JOIN pg_catalog.pg_class AS c ON a.attrelid = c.oid
				JOIN pg_catalog.pg_namespace AS n ON n.oid = c.relnamespace
				JOIN pg_catalog.pg_type AS t ON a.atttypid = t.oid
				LEFT JOIN pg_catalog.pg_attrdef AS ad ON ad.adrelid = c.oid AND ad.adnum = a.attnum
				LEFT JOIN pg_catalog.pg_constraint AS co ON co.connamespace = n.oid AND contype = 'p' AND co.conrelid = c.oid AND a.attnum = ANY(co.conkey)
			WHERE
				c.relkind IN ('r', 'v')
				AND c.relname::varchar = {$this->connection->quote($table)}
				AND n.nspname = current_schema()
				AND a.attnum > 0
				AND NOT a.attisdropped
			ORDER BY
				a.attnum
		")as$row){$column=(array)$row;$column['vendor']=$column;unset($column['sequence']);$columns[]=$column;}return$columns;}function
getIndexes($table){$indexes=array();foreach($this->connection->query("
			SELECT
				c2.relname::varchar AS name,
				i.indisunique AS unique,
				i.indisprimary AS primary,
				a.attname::varchar AS column
			FROM
				pg_catalog.pg_class AS c1
				JOIN pg_catalog.pg_namespace AS n ON c1.relnamespace = n.oid
				JOIN pg_catalog.pg_index AS i ON c1.oid = i.indrelid
				JOIN pg_catalog.pg_class AS c2 ON i.indexrelid = c2.oid
				LEFT JOIN pg_catalog.pg_attribute AS a ON c1.oid = a.attrelid AND a.attnum = ANY(i.indkey)
			WHERE
				n.nspname = current_schema()
				AND c1.relkind = 'r'
				AND c1.relname = {$this->connection->quote($table)}
		")as$row){$indexes[$row['name']]['name']=$row['name'];$indexes[$row['name']]['unique']=$row['unique'];$indexes[$row['name']]['primary']=$row['primary'];$indexes[$row['name']]['columns'][]=$row['column'];}return
array_values($indexes);}function
getForeignKeys($table){return$this->connection->query("
			SELECT
				co.conname::varchar AS name,
				al.attname::varchar AS local,
				cf.relname::varchar AS table,
				af.attname::varchar AS foreign
			FROM
				pg_catalog.pg_constraint AS co
				JOIN pg_catalog.pg_namespace AS n ON co.connamespace = n.oid
				JOIN pg_catalog.pg_class AS cl ON co.conrelid = cl.oid
				JOIN pg_catalog.pg_class AS cf ON co.confrelid = cf.oid
				JOIN pg_catalog.pg_attribute AS al ON al.attrelid = cl.oid AND al.attnum = co.conkey[1]
				JOIN pg_catalog.pg_attribute AS af ON af.attrelid = cf.oid AND af.attnum = co.confkey[1]
			WHERE
				n.nspname = current_schema()
				AND co.contype = 'f'
				AND cl.relname = {$this->connection->quote($table)}
		")->fetchAll();}function
getColumnTypes(\PDOStatement$statement){return
Nette\Database\Helpers::detectTypes($statement);}function
isSupported($item){return$item===self::SUPPORT_SEQUENCE||$item===self::SUPPORT_SUBSELECT;}}class
SqliteDriver
extends
Nette\Object
implements
Nette\Database\ISupplementalDriver{private$connection;private$fmtDateTime;function
__construct(Nette\Database\Connection$connection,array$options){$this->connection=$connection;$this->fmtDateTime=isset($options['formatDateTime'])?$options['formatDateTime']:'U';}function
delimite($name){return'['.strtr($name,'[]','  ').']';}function
formatBool($value){return$value?'1':'0';}function
formatDateTime(\DateTime$value){return$value->format($this->fmtDateTime);}function
formatLike($value,$pos){$value=addcslashes(substr($this->connection->quote($value),1,-1),'%_\\');return($pos<=0?"'%":"'").$value.($pos>=0?"%'":"'")." ESCAPE '\\'";}function
applyLimit(&$sql,$limit,$offset){if($limit>=0||$offset>0){$sql.=' LIMIT '.(int)$limit.($offset>0?' OFFSET '.(int)$offset:'');}}function
normalizeRow($row){foreach($row
as$key=>$value){unset($row[$key]);if($key[0]==='['||$key[0]==='"'){$key=substr($key,1,-1);}$row[$key]=$value;}return$row;}function
getTables(){$tables=array();foreach($this->connection->query("
			SELECT name, type = 'view' as view FROM sqlite_master WHERE type IN ('table', 'view') AND name NOT LIKE 'sqlite_%'
			UNION ALL
			SELECT name, type = 'view' as view FROM sqlite_temp_master WHERE type IN ('table', 'view') AND name NOT LIKE 'sqlite_%'
			ORDER BY name
		")as$row){$tables[]=array('name'=>$row->name,'view'=>(bool)$row->view);}return$tables;}function
getColumns($table){$meta=$this->connection->query("
			SELECT sql FROM sqlite_master WHERE type = 'table' AND name = {$this->connection->quote($table)}
			UNION ALL
			SELECT sql FROM sqlite_temp_master WHERE type = 'table' AND name = {$this->connection->quote($table)}
		")->fetch();$columns=array();foreach($this->connection->query("PRAGMA table_info({$this->delimite($table)})")as$row){$column=$row['name'];$pattern="/(\"$column\"|\[$column\]|$column)\\s+[^,]+\\s+PRIMARY\\s+KEY\\s+AUTOINCREMENT/Ui";$type=explode('(',$row['type']);$columns[]=array('name'=>$column,'table'=>$table,'nativetype'=>strtoupper($type[0]),'size'=>isset($type[1])?(int)$type[1]:NULL,'unsigned'=>FALSE,'nullable'=>$row['notnull']=='0','default'=>$row['dflt_value'],'autoincrement'=>(bool)preg_match($pattern,$meta['sql']),'primary'=>$row['pk']=='1','vendor'=>(array)$row);}return$columns;}function
getIndexes($table){$indexes=array();foreach($this->connection->query("PRAGMA index_list({$this->delimite($table)})")as$row){$indexes[$row['name']]['name']=$row['name'];$indexes[$row['name']]['unique']=(bool)$row['unique'];$indexes[$row['name']]['primary']=FALSE;}foreach($indexes
as$index=>$values){$res=$this->connection->query("PRAGMA index_info({$this->delimite($index)})");while($row=$res->fetch(TRUE)){$indexes[$index]['columns'][$row['seqno']]=$row['name'];}}$columns=$this->getColumns($table);foreach($indexes
as$index=>$values){$column=$indexes[$index]['columns'][0];foreach($columns
as$info){if($column==$info['name']){$indexes[$index]['primary']=(bool)$info['primary'];break;}}}if(!$indexes){foreach($columns
as$column){if($column['vendor']['pk']){$indexes[]=array('name'=>'ROWID','unique'=>TRUE,'primary'=>TRUE,'columns'=>array($column['name']));break;}}}return
array_values($indexes);}function
getForeignKeys($table){$keys=array();foreach($this->connection->query("PRAGMA foreign_key_list({$this->delimite($table)})")as$row){$keys[$row['id']]['name']=$row['id'];$keys[$row['id']]['local']=$row['from'];$keys[$row['id']]['table']=$row['table'];$keys[$row['id']]['foreign']=$row['to'];$keys[$row['id']]['onDelete']=$row['on_delete'];$keys[$row['id']]['onUpdate']=$row['on_update'];if($keys[$row['id']]['foreign'][0]==NULL){$keys[$row['id']]['foreign']=NULL;}}return
array_values($keys);}function
getColumnTypes(\PDOStatement$statement){$types=array();$count=$statement->columnCount();for($col=0;$col<$count;$col++){$meta=$statement->getColumnMeta($col);if(isset($meta['sqlite:decl_type'])){if($meta['sqlite:decl_type']==='DATE'){$types[$meta['name']]=Nette\Database\IReflection::FIELD_UNIX_TIMESTAMP;}else{$types[$meta['name']]=Nette\Database\Helpers::detectType($meta['sqlite:decl_type']);}}elseif(isset($meta['native_type'])){$types[$meta['name']]=Nette\Database\Helpers::detectType($meta['native_type']);}}return$types;}function
isSupported($item){return$item===self::SUPPORT_MULTI_INSERT_AS_SELECT||$item===self::SUPPORT_SUBSELECT||$item===self::SUPPORT_MULTI_COLUMN_AS_OR_COND;}}class
Sqlite2Driver
extends
SqliteDriver{function
formatLike($value,$pos){throw
new
Nette\NotSupportedException;}function
getForeignKeys($table){throw
new
Nette\NotSupportedException;}}class
SqlsrvDriver
extends
Nette\Object
implements
Nette\Database\ISupplementalDriver{private$connection;function
__construct(Nette\Database\Connection$connection,array$options){$this->connection=$connection;}function
delimite($name){return'['.str_replace(']',']]',$name).']';}function
formatBool($value){return$value?'1':'0';}function
formatDateTime(\DateTime$value){return$value->format("'Y-m-d H:i:s'");}function
formatLike($value,$pos){$value=strtr($value,array("'"=>"''",'%'=>'[%]','_'=>'[_]','['=>'[[]'));return($pos<=0?"'%":"'").$value.($pos>=0?"%'":"'");}function
applyLimit(&$sql,$limit,$offset){if($limit>=0){$sql=preg_replace('#^\s*(SELECT|UPDATE|DELETE)#i','$0 TOP '.(int)$limit,$sql,1,$count);if(!$count){throw
new
Nette\InvalidArgumentException('SQL query must begin with SELECT, UPDATE or DELETE command.');}}if($offset){throw
new
Nette\NotSupportedException('Offset is not supported by this database.');}}function
normalizeRow($row){return$row;}function
getTables(){$tables=array();foreach($this->connection->query("
			SELECT
				name,
				CASE type
					WHEN 'U' THEN 0
					WHEN 'V' THEN 1
				END AS [view]
			FROM
				sys.objects
			WHERE
				type IN ('U', 'V')
		")as$row){$tables[]=array('name'=>$row->name,'view'=>(bool)$row->view);}return$tables;}function
getColumns($table){$columns=array();foreach($this->connection->query("
			SELECT
				c.name AS name,
				o.name AS [table],
				UPPER(t.name) AS nativetype,
				NULL AS size,
				0 AS unsigned,
				c.is_nullable AS nullable,
				OBJECT_DEFINITION(c.default_object_id) AS [default],
				c.is_identity AS autoincrement,
				CASE WHEN i.index_id IS NULL
					THEN 0
					ELSE 1
				END AS [primary]
			FROM
				sys.columns c
				JOIN sys.objects o ON c.object_id = o.object_id
				LEFT JOIN sys.types t ON c.user_type_id = t.user_type_id
				LEFT JOIN sys.key_constraints k ON o.object_id = k.parent_object_id AND k.type = 'PK'
				LEFT JOIN sys.index_columns i ON k.parent_object_id = i.object_id AND i.index_id = k.unique_index_id AND i.column_id = c.column_id
			WHERE
				o.type IN ('U', 'V')
				AND o.name = {$this->connection->quote($table)}
		")as$row){$row=(array)$row;$row['vendor']=$row;$row['unsigned']=(bool)$row['unsigned'];$row['nullable']=(bool)$row['nullable'];$row['autoincrement']=(bool)$row['autoincrement'];$row['primary']=(bool)$row['primary'];$columns[]=$row;}return$columns;}function
getIndexes($table){$indexes=array();foreach($this->connection->query("
			SELECT
				i.name AS name,
				CASE WHEN i.is_unique = 1 OR i.is_unique_constraint = 1
					THEN 1
					ELSE 0
				END AS [unique],
				i.is_primary_key AS [primary],
				c.name AS [column]
			FROM
				sys.indexes i
				JOIN sys.index_columns ic ON i.object_id = ic.object_id AND i.index_id = ic.index_id
				JOIN sys.columns c ON ic.object_id = c.object_id AND ic.column_id = c.column_id
				JOIN sys.tables t ON i.object_id = t.object_id
			WHERE
				t.name = {$this->connection->quote($table)}
			ORDER BY
				i.index_id,
				ic.index_column_id
		")as$row){$indexes[$row->name]['name']=$row->name;$indexes[$row->name]['unique']=(bool)$row->unique;$indexes[$row->name]['primary']=(bool)$row->primary;$indexes[$row->name]['columns'][]=$row->column;}return
array_values($indexes);}function
getForeignKeys($table){$keys=array();foreach($this->connection->query("
			SELECT
				fk.name AS name,
				cl.name AS local,
				tf.name AS [table],
				cf.name AS [column]
			FROM
				sys.foreign_keys fk
				JOIN sys.foreign_key_columns fkc ON fk.object_id = fkc.constraint_object_id
				JOIN sys.tables tl ON fkc.parent_object_id = tl.object_id
				JOIN sys.columns cl ON fkc.parent_object_id = cl.object_id AND fkc.parent_column_id = cl.column_id
				JOIN sys.tables tf ON fkc.referenced_object_id = tf.object_id
				JOIN sys.columns cf ON fkc.referenced_object_id = cf.object_id AND fkc.referenced_column_id = cf.column_id
			WHERE
				tl.name = {$this->connection->quote($table)}
		")as$row){$keys[$row->name]=(array)$row;}return
array_values($keys);}function
getColumnTypes(\PDOStatement$statement){$types=array();$count=$statement->columnCount();for($col=0;$col<$count;$col++){$meta=$statement->getColumnMeta($col);if(isset($meta['sqlsrv:decl_type'])&&$meta['sqlsrv:decl_type']!=='timestamp'){$types[$meta['name']]=Nette\Database\Helpers::detectType($meta['sqlsrv:decl_type']);}elseif(isset($meta['native_type'])){$types[$meta['name']]=Nette\Database\Helpers::detectType($meta['native_type']);}}return$types;}function
isSupported($item){return$item===self::SUPPORT_SUBSELECT;}}}namespace Nette\Database{use
Nette;class
Helpers{static
public$maxLength=100;public
static$typePatterns=array('^_'=>IReflection::FIELD_TEXT,'BYTEA|BLOB|BIN'=>IReflection::FIELD_BINARY,'TEXT|CHAR|POINT|INTERVAL'=>IReflection::FIELD_TEXT,'YEAR|BYTE|COUNTER|SERIAL|INT|LONG|SHORT|^TINY$'=>IReflection::FIELD_INTEGER,'CURRENCY|REAL|MONEY|FLOAT|DOUBLE|DECIMAL|NUMERIC|NUMBER'=>IReflection::FIELD_FLOAT,'^TIME$'=>IReflection::FIELD_TIME,'TIME'=>IReflection::FIELD_DATETIME,'DATE'=>IReflection::FIELD_DATE,'BOOL'=>IReflection::FIELD_BOOL);static
function
dumpResult(ResultSet$result){echo"\n<table class=\"dump\">\n<caption>".htmlSpecialChars($result->getQueryString())."</caption>\n";if(!$result->getColumnCount()){echo"\t<tr>\n\t\t<th>Affected rows:</th>\n\t\t<td>",$result->getRowCount(),"</td>\n\t</tr>\n</table>\n";return;}$i=0;foreach($result
as$row){if($i===0){echo"<thead>\n\t<tr>\n\t\t<th>#row</th>\n";foreach($row
as$col=>$foo){echo"\t\t<th>".htmlSpecialChars($col)."</th>\n";}echo"\t</tr>\n</thead>\n<tbody>\n";}echo"\t<tr>\n\t\t<th>",$i,"</th>\n";foreach($row
as$col){echo"\t\t<td>",htmlSpecialChars($col),"</td>\n";}echo"\t</tr>\n";$i++;}if($i===0){echo"\t<tr>\n\t\t<td><em>empty result set</em></td>\n\t</tr>\n</table>\n";}else{echo"</tbody>\n</table>\n";}}static
function
dumpSql($sql,array$params=NULL){static$keywords1='SELECT|(?:ON\s+DUPLICATE\s+KEY)?UPDATE|INSERT(?:\s+INTO)?|REPLACE(?:\s+INTO)?|DELETE|CALL|UNION|FROM|WHERE|HAVING|GROUP\s+BY|ORDER\s+BY|LIMIT|OFFSET|SET|VALUES|LEFT\s+JOIN|INNER\s+JOIN|TRUNCATE';static$keywords2='ALL|DISTINCT|DISTINCTROW|IGNORE|AS|USING|ON|AND|OR|IN|IS|NOT|NULL|LIKE|RLIKE|REGEXP|TRUE|FALSE';$sql=" $sql ";$sql=preg_replace("#(?<=[\\s,(])($keywords1)(?=[\\s,)])#i","\n\$1",$sql);$sql=preg_replace('#[ \t]{2,}#'," ",$sql);$sql=wordwrap($sql,100);$sql=preg_replace('#([ \t]*\r?\n){2,}#',"\n",$sql);$sql=htmlSpecialChars($sql);$sql=preg_replace_callback("#(/\\*.+?\\*/)|(\\*\\*.+?\\*\\*)|(?<=[\\s,(])($keywords1)(?=[\\s,)])|(?<=[\\s,(=])($keywords2)(?=[\\s,)=])#is",function($matches){if(!empty($matches[1])){return'<em style="color:gray">'.$matches[1].'</em>';}elseif(!empty($matches[2])){return'<strong style="color:red">'.$matches[2].'</strong>';}elseif(!empty($matches[3])){return'<strong style="color:blue">'.$matches[3].'</strong>';}elseif(!empty($matches[4])){return'<strong style="color:green">'.$matches[4].'</strong>';}},$sql);$sql=preg_replace_callback('#\?#',function()use($params){static$i=0;if(!isset($params[$i])){return'?';}$param=$params[$i++];if(is_string($param)&&(preg_match('#[^\x09\x0A\x0D\x20-\x7E\xA0-\x{10FFFF}]#u',$param)||preg_last_error())){return'<i title="Length '.strlen($param).' bytes">&lt;binary&gt;</i>';}elseif(is_string($param)){return'<span title="Length '.Nette\Utils\Strings::length($param).' characters">\''.htmlspecialchars(Nette\Utils\Strings::truncate($param,Helpers::$maxLength))."'</span>";}elseif(is_resource($param)){$type=get_resource_type($param);if($type==='stream'){$info=stream_get_meta_data($param);}return'<i'.(isset($info['uri'])?' title="'.htmlspecialchars($info['uri']).'"':NULL).'>&lt;'.htmlSpecialChars($type)." resource&gt;</i> ";}else{return
htmlspecialchars($param);}},$sql);return'<pre class="dump">'.trim($sql)."</pre>\n";}static
function
detectTypes(\PDOStatement$statement){$types=array();$count=$statement->columnCount();for($col=0;$col<$count;$col++){$meta=$statement->getColumnMeta($col);if(isset($meta['native_type'])){$types[$meta['name']]=self::detectType($meta['native_type']);}}return$types;}static
function
detectType($type){static$cache;if(!isset($cache[$type])){$cache[$type]='string';foreach(self::$typePatterns
as$s=>$val){if(preg_match("#$s#i",$type)){return$cache[$type]=$val;}}}return$cache[$type];}static
function
loadFromFile(Connection$connection,$file){@set_time_limit(0);$handle=@fopen($file,'r');if(!$handle){throw
new
Nette\FileNotFoundException("Cannot open file '$file'.");}$count=0;$sql='';while(!feof($handle)){$s=fgets($handle);$sql.=$s;if(substr(rtrim($s),-1)===';'){$connection->query($sql);$sql='';$count++;}}if(trim($sql)!==''){$connection->query($sql);$count++;}fclose($handle);return$count;}static
function
createDebugPanel($connection,$explain=TRUE,$name=NULL){$panel=new
Nette\Database\Diagnostics\ConnectionPanel($connection);$panel->explain=$explain;$panel->name=$name;Nette\Diagnostics\Debugger::getBar()->addPanel($panel);return$panel;}}}namespace Nette\Database\Reflection{use
Nette;class
ConventionalReflection
extends
Nette\Object
implements
Nette\Database\IReflection{protected$primary;protected$foreign;protected$table;function
__construct($primary='id',$foreign='%s_id',$table='%s'){$this->primary=$primary;$this->foreign=$foreign;$this->table=$table;}function
getPrimary($table){return
sprintf($this->primary,$this->getColumnFromTable($table));}function
getHasManyReference($table,$key){$table=$this->getColumnFromTable($table);return
array(sprintf($this->table,$key,$table),sprintf($this->foreign,$table,$key));}function
getBelongsToReference($table,$key){$table=$this->getColumnFromTable($table);return
array(sprintf($this->table,$key,$table),sprintf($this->foreign,$key,$table));}protected
function
getColumnFromTable($name){if($this->table!=='%s'&&preg_match('(^'.str_replace('%s','(.*)',preg_quote($this->table)).'\z)',$name,$match)){return$match[1];}return$name;}}class
DiscoveredReflection
extends
Nette\Object
implements
Nette\Database\IReflection{protected$connection;protected$cache;protected$structure=array();protected$loadedStructure;function
__construct(Nette\Database\Connection$connection,Nette\Caching\IStorage$cacheStorage=NULL){$this->connection=$connection;if($cacheStorage){$this->cache=new
Nette\Caching\Cache($cacheStorage,'Nette.Database.'.md5($connection->getDsn()));$this->structure=$this->loadedStructure=$this->cache->load('structure')?:array();}}function
__destruct(){if($this->cache&&$this->structure!==$this->loadedStructure){$this->cache->save('structure',$this->structure);}}function
getPrimary($table){$primary=&$this->structure['primary'][strtolower($table)];if(isset($primary)){return
empty($primary)?NULL:$primary;}$columns=$this->connection->getSupplementalDriver()->getColumns($table);$primary=array();foreach($columns
as$column){if($column['primary']){$primary[]=$column['name'];}}if(count($primary)===0){return
NULL;}elseif(count($primary)===1){$primary=reset($primary);}return$primary;}function
getHasManyReference($table,$key,$refresh=TRUE){if(isset($this->structure['hasMany'][strtolower($table)])){$candidates=$columnCandidates=array();foreach($this->structure['hasMany'][strtolower($table)]as$targetPair){list($targetColumn,$targetTable)=$targetPair;if(stripos($targetTable,$key)===FALSE){continue;}$candidates[]=array($targetTable,$targetColumn);if(stripos($targetColumn,$table)!==FALSE){$columnCandidates[]=$candidate=array($targetTable,$targetColumn);if(strtolower($targetTable)===strtolower($key)){return$candidate;}}}if(count($columnCandidates)===1){return
reset($columnCandidates);}elseif(count($candidates)===1){return
reset($candidates);}foreach($candidates
as$candidate){list($targetTable,$targetColumn)=$candidate;if(strtolower($targetTable)===strtolower($key)){return$candidate;}}}if($refresh){$this->reloadAllForeignKeys();return$this->getHasManyReference($table,$key,FALSE);}if(empty($candidates)){throw
new
MissingReferenceException("No reference found for \${$table}->related({$key}).");}else{throw
new
AmbiguousReferenceKeyException('Ambiguous joining column in related call.');}}function
getBelongsToReference($table,$key,$refresh=TRUE){if(isset($this->structure['belongsTo'][strtolower($table)])){foreach($this->structure['belongsTo'][strtolower($table)]as$column=>$targetTable){if(stripos($column,$key)!==FALSE){return
array($targetTable,$column);}}}if($refresh){$this->reloadForeignKeys($table);return$this->getBelongsToReference($table,$key,FALSE);}throw
new
MissingReferenceException("No reference found for \${$table}->{$key}.");}protected
function
reloadAllForeignKeys(){$this->structure['hasMany']=$this->structure['belongsTo']=array();foreach($this->connection->getSupplementalDriver()->getTables()as$table){if($table['view']==FALSE){$this->reloadForeignKeys($table['name']);}}foreach($this->structure['hasMany']as&$table){uksort($table,function($a,$b){return
strlen($a)-strlen($b);});}}protected
function
reloadForeignKeys($table){foreach($this->connection->getSupplementalDriver()->getForeignKeys($table)as$row){$this->structure['belongsTo'][strtolower($table)][$row['local']]=$row['table'];$this->structure['hasMany'][strtolower($row['table'])][$row['local'].$table]=array($row['local'],$table);}if(isset($this->structure['belongsTo'][$table])){uksort($this->structure['belongsTo'][$table],function($a,$b){return
strlen($a)-strlen($b);});}}}use
PDOException;if(class_exists('PDO')){class
MissingReferenceException
extends
PDOException{}class
AmbiguousReferenceKeyException
extends
PDOException{}}}namespace Nette\Database{use
Nette;use
PDO;use
Nette\ObjectMixin;class
ResultSet
extends
Nette\Object
implements\Iterator,IRowContainer{private$connection;private$pdoStatement;private$result;private$resultKey=-1;private$results;private$time;private$queryString;private$params;private$types;function
__construct(Connection$connection,$queryString,array$params){$time=microtime(TRUE);$this->connection=$connection;$this->queryString=$queryString;$this->params=$params;if(substr($queryString,0,2)==='::'){$connection->getPdo()->{substr($queryString,2)}();}elseif($queryString!==NULL){$this->pdoStatement=$connection->getPdo()->prepare($queryString);$this->pdoStatement->setFetchMode(PDO::FETCH_ASSOC);$this->pdoStatement->execute($params);}$this->time=microtime(TRUE)-$time;}function
getConnection(){return$this->connection;}function
getPdoStatement(){return$this->pdoStatement;}function
getQueryString(){return$this->queryString;}function
getParameters(){return$this->params;}function
getColumnCount(){return$this->pdoStatement?$this->pdoStatement->columnCount():NULL;}function
getRowCount(){return$this->pdoStatement?$this->pdoStatement->rowCount():NULL;}function
getTime(){return$this->time;}function
normalizeRow($row){if($this->types===NULL){$this->types=(array)$this->connection->getSupplementalDriver()->getColumnTypes($this->pdoStatement);}foreach($this->types
as$key=>$type){$value=$row[$key];if($value===NULL||$value===FALSE||$type===IReflection::FIELD_TEXT){}elseif($type===IReflection::FIELD_INTEGER){$row[$key]=is_float($tmp=$value*1)?$value:$tmp;}elseif($type===IReflection::FIELD_FLOAT){if(($pos=strpos($value,'.'))!==FALSE){$value=rtrim(rtrim($pos===0?"0$value":$value,'0'),'.');}$float=(float)$value;$row[$key]=(string)$float===$value?$float:$value;}elseif($type===IReflection::FIELD_BOOL){$row[$key]=((bool)$value)&&$value!=='f'&&$value!=='F';}elseif($type===IReflection::FIELD_DATETIME||$type===IReflection::FIELD_DATE||$type===IReflection::FIELD_TIME){$row[$key]=new
Nette\DateTime($value);}elseif($type===IReflection::FIELD_UNIX_TIMESTAMP){$row[$key]=Nette\DateTime::from($value);}}return$this->connection->getSupplementalDriver()->normalizeRow($row);}function
dump(){Helpers::dumpResult($this);}function
rewind(){if($this->result===FALSE){throw
new
Nette\InvalidStateException('Nette\\Database\\ResultSet implements only one way iterator.');}}function
current(){return$this->result;}function
key(){return$this->resultKey;}function
next(){$this->result=FALSE;}function
valid(){if($this->result){return
TRUE;}return$this->fetch()!==FALSE;}function
fetch(){$data=$this->pdoStatement?$this->pdoStatement->fetch():NULL;if(!$data){$this->pdoStatement->closeCursor();return
FALSE;}$row=new
Row;foreach($this->normalizeRow($data)as$key=>$value){$row->$key=$value;}if($this->result===NULL&&count($data)!==$this->pdoStatement->columnCount()){trigger_error('Found duplicate columns in database result set.',E_USER_NOTICE);}$this->resultKey++;return$this->result=$row;}function
fetchField($column=0){$row=$this->fetch();return$row?$row[$column]:FALSE;}function
fetchPairs($key,$value=NULL){$return=array();foreach($this->fetchAll()as$row){$return[is_object($row[$key])?(string)$row[$key]:$row[$key]]=($value===NULL?$row:$row[$value]);}return$return;}function
fetchAll(){if($this->results===NULL){$this->results=iterator_to_array($this);}return$this->results;}function
columnCount(){trigger_error(__METHOD__.'() is deprecated; use getColumnCount() instead.',E_USER_DEPRECATED);return$this->getColumnCount();}function
rowCount(){trigger_error(__METHOD__.'() is deprecated; use getRowCount() instead.',E_USER_DEPRECATED);return$this->getRowCount();}}class
Row
extends
Nette\ArrayHash
implements
IRow{function
offsetGet($key){if(is_int($key)){$arr=array_slice((array)$this,$key,1);if(!$arr){trigger_error('Undefined offset: '.__CLASS__."[$key]",E_USER_NOTICE);}return
current($arr);}return$this->$key;}function
offsetExists($key){if(is_int($key)){return(bool)array_slice((array)$this,$key,1);}return
parent::offsetExists($key);}}class
SelectionFactory
extends
Nette\Object{private$connection;private$reflection;private$cacheStorage;function
__construct(Connection$connection,IReflection$reflection=NULL,Nette\Caching\IStorage$cacheStorage=NULL){$this->connection=$connection;$this->reflection=$reflection?:new
Reflection\ConventionalReflection;$this->cacheStorage=$cacheStorage;}function
table($table){return
new
Table\Selection($this->connection,$table,$this->reflection,$this->cacheStorage);}function
getConnection(){return$this->connection;}}class
SqlLiteral
extends
Nette\Object{private$value;private$parameters;function
__construct($value,array$parameters=array()){$this->value=(string)$value;$this->parameters=$parameters;}function
getParameters(){return$this->parameters;}function
__toString(){return$this->value;}}class
SqlPreprocessor
extends
Nette\Object{private$connection;private$driver;private$params;private$remaining;private$counter;private$arrayMode;private$arrayModes;function
__construct(Connection$connection){$this->connection=$connection;$this->driver=$connection->getSupplementalDriver();$this->arrayModes=array('INSERT'=>$this->driver->isSupported(ISupplementalDriver::SUPPORT_MULTI_INSERT_AS_SELECT)?'select':'values','REPLACE'=>'values','UPDATE'=>'assoc','WHERE'=>'and','HAVING'=>'and','ORDER BY'=>'order','GROUP BY'=>'order');}function
process($params){$this->params=$params;$this->counter=0;$this->remaining=array();$this->arrayMode='assoc';$res=array();while($this->counter<count($params)){$param=$params[$this->counter++];if(($this->counter===2&&count($params)===2)||!is_scalar($param)){$res[]=$this->formatValue($param);}else{$res[]=Nette\Utils\Strings::replace($param,'~\'.*?\'|".*?"|\?|\b(?:INSERT|REPLACE|UPDATE|WHERE|HAVING|ORDER BY|GROUP BY)\b~si',array($this,'callback'));}}return
array(implode(' ',$res),$this->remaining);}function
callback($m){$m=$m[0];if($m[0]==="'"||$m[0]==='"'){return$m;}elseif($m==='?'){if($this->counter>=count($this->params)){throw
new
Nette\InvalidArgumentException('There are more placeholders than passed parameters.');}return$this->formatValue($this->params[$this->counter++]);}else{$this->arrayMode=$this->arrayModes[strtoupper($m)];return$m;}}private
function
formatValue($value){if(is_string($value)){if(strlen($value)>20){$this->remaining[]=$value;return'?';}else{return$this->connection->quote($value);}}elseif(is_int($value)){return(string)$value;}elseif(is_float($value)){return
rtrim(rtrim(number_format($value,10,'.',''),'0'),'.');}elseif(is_bool($value)){return$this->driver->formatBool($value);}elseif($value===NULL){return'NULL';}elseif($value
instanceof
Table\IRow){return$value->getPrimary();}elseif(is_array($value)||$value
instanceof\Traversable){$vx=$kx=array();if($value
instanceof\Traversable){$value=iterator_to_array($value);}if(isset($value[0])){foreach($value
as$v){if(is_array($v)&&isset($v[0])){$vx[]='('.$this->formatValue($v).')';}else{$vx[]=$this->formatValue($v);}}if($this->arrayMode==='union'){return
implode(' ',$vx);}return
implode(', ',$vx);}elseif($this->arrayMode==='values'){$this->arrayMode='multi';foreach($value
as$k=>$v){$kx[]=$this->driver->delimite($k);$vx[]=$this->formatValue($v);}return'('.implode(', ',$kx).') VALUES ('.implode(', ',$vx).')';}elseif($this->arrayMode==='select'){$this->arrayMode='union';foreach($value
as$k=>$v){$kx[]=$this->driver->delimite($k);$vx[]=$this->formatValue($v);}return'('.implode(', ',$kx).') SELECT '.implode(', ',$vx);}elseif($this->arrayMode==='assoc'){foreach($value
as$k=>$v){$vx[]=$this->driver->delimite($k).'='.$this->formatValue($v);}return
implode(', ',$vx);}elseif($this->arrayMode==='multi'){foreach($value
as$k=>$v){$vx[]=$this->formatValue($v);}return'('.implode(', ',$vx).')';}elseif($this->arrayMode==='union'){foreach($value
as$k=>$v){$vx[]=$this->formatValue($v);}return'UNION ALL SELECT '.implode(', ',$vx);}elseif($this->arrayMode==='and'){foreach($value
as$k=>$v){$k=$this->driver->delimite($k);if(is_array($v)){$vx[]=$v?($k.' IN ('.$this->formatValue(array_values($v)).')'):'1=0';}else{$v=$this->formatValue($v);$vx[]=$k.($v==='NULL'?' IS ':' = ').$v;}}return$value?'('.implode(') AND (',$vx).')':'1=1';}elseif($this->arrayMode==='order'){foreach($value
as$k=>$v){$vx[]=$this->driver->delimite($k).($v>0?'':' DESC');}return
implode(', ',$vx);}}elseif($value
instanceof\DateTime){return$this->driver->formatDateTime($value);}elseif($value
instanceof
SqlLiteral){$this->remaining=array_merge($this->remaining,$value->getParameters());return$value->__toString();}else{$this->remaining[]=$value;return'?';}}}}namespace Nette\Database\Table{use
Nette;use
Nette\Database\Reflection\MissingReferenceException;class
ActiveRow
implements\IteratorAggregate,IRow{private$table;private$data;private$dataRefreshed=FALSE;private$isModified=FALSE;function
__construct(array$data,Selection$table){$this->data=$data;$this->table=$table;}function
setTable(Selection$table){$this->table=$table;}function
getTable(){return$this->table;}function
__toString(){try{return(string)$this->getPrimary();}catch(\Exception$e){trigger_error("Exception in ".__METHOD__."(): {$e->getMessage()} in {$e->getFile()}:{$e->getLine()}",E_USER_ERROR);}}function
toArray(){$this->accessColumn(NULL);return$this->data;}function
getPrimary($need=TRUE){$primary=$this->table->getPrimary($need);if($primary===NULL){return
NULL;}elseif(!is_array($primary)){if(isset($this->data[$primary])){return$this->data[$primary];}elseif($need){throw
new
Nette\InvalidStateException("Row does not contain primary $primary column data.");}else{return
NULL;}}else{$primaryVal=array();foreach($primary
as$key){if(!isset($this->data[$key])){if($need){throw
new
Nette\InvalidStateException("Row does not contain primary $key column data.");}else{return
NULL;}}$primaryVal[$key]=$this->data[$key];}return$primaryVal;}}function
getSignature($need=TRUE){return
implode('|',(array)$this->getPrimary($need));}function
ref($key,$throughColumn=NULL){if(!$throughColumn){list($key,$throughColumn)=$this->table->getDatabaseReflection()->getBelongsToReference($this->table->getName(),$key);}return$this->getReference($key,$throughColumn);}function
related($key,$throughColumn=NULL){if(strpos($key,'.')!==FALSE){list($key,$throughColumn)=explode('.',$key);}elseif(!$throughColumn){list($key,$throughColumn)=$this->table->getDatabaseReflection()->getHasManyReference($this->table->getName(),$key);}return$this->table->getReferencingTable($key,$throughColumn,$this[$this->table->getPrimary()]);}function
update($data){$selection=$this->table->createSelectionInstance()->wherePrimary($this->getPrimary());if($selection->update($data)){$this->isModified=TRUE;$selection->select('*');if(($row=$selection->fetch())===FALSE){throw
new
Nette\InvalidStateException('Database refetch failed; row does not exist!');}$this->data=$row->data;return
TRUE;}else{return
FALSE;}}function
delete(){$res=$this->table->createSelectionInstance()->wherePrimary($this->getPrimary())->delete();if($res>0&&($signature=$this->getSignature(FALSE))){unset($this->table[$signature]);}return$res;}function
getIterator(){$this->accessColumn(NULL);return
new\ArrayIterator($this->data);}function
offsetSet($key,$value){$this->__set($key,$value);}function
offsetGet($key){return$this->__get($key);}function
offsetExists($key){return$this->__isset($key);}function
offsetUnset($key){$this->__unset($key);}function
__set($key,$value){throw
new
Nette\DeprecatedException('ActiveRow is read-only; use update() method instead.');}function&__get($key){$this->accessColumn($key);if(array_key_exists($key,$this->data)){return$this->data[$key];}try{list($table,$column)=$this->table->getDatabaseReflection()->getBelongsToReference($this->table->getName(),$key);$referenced=$this->getReference($table,$column);if($referenced!==FALSE){$this->accessColumn($key,FALSE);return$referenced;}}catch(MissingReferenceException$e){}$this->removeAccessColumn($key);throw
new
Nette\MemberAccessException("Cannot read an undeclared column \"$key\".");}function
__isset($key){$this->accessColumn($key);if(array_key_exists($key,$this->data)){return
isset($this->data[$key]);}$this->removeAccessColumn($key);return
FALSE;}function
__unset($key){throw
new
Nette\DeprecatedException('ActiveRow is read-only.');}protected
function
accessColumn($key,$selectColumn=TRUE){$this->table->accessColumn($key,$selectColumn);if($this->table->getDataRefreshed()&&!$this->dataRefreshed){$this->data=$this->table[$this->getSignature()]->data;$this->dataRefreshed=TRUE;}}protected
function
removeAccessColumn($key){$this->table->removeAccessColumn($key);}protected
function
getReference($table,$column){$this->accessColumn($column);if(array_key_exists($column,$this->data)){$value=$this->data[$column];$referenced=$this->table->getReferencedTable($table,$column,$value);return
isset($referenced[$value])?$referenced[$value]:NULL;}return
FALSE;}}use
Nette\Database\ISupplementalDriver;class
Selection
extends
Nette\Object
implements\Iterator,IRowContainer,\ArrayAccess,\Countable{protected$connection;protected$reflection;protected$cache;protected$sqlBuilder;protected$name;protected$primary;protected$primarySequence=FALSE;protected$rows;protected$data;protected$dataRefreshed=FALSE;protected$globalRefCache;protected$refCache;protected$generalCacheKey;protected$specificCacheKey;protected$aggregation=array();protected$accessedColumns;protected$previousAccessedColumns;protected$observeCache=FALSE;protected$keys=array();function
__construct(Nette\Database\Connection$connection,$table,Nette\Database\IReflection$reflection,Nette\Caching\IStorage$cacheStorage=NULL){$this->name=$table;$this->connection=$connection;$this->reflection=$reflection;$this->cache=$cacheStorage?new
Nette\Caching\Cache($cacheStorage,'Nette.Database.'.md5($connection->getDsn())):NULL;$this->primary=$reflection->getPrimary($table);$this->sqlBuilder=new
SqlBuilder($table,$connection,$reflection);$this->refCache=&$this->getRefTable($refPath)->globalRefCache[$refPath];}function
__destruct(){$this->saveCacheState();}function
__clone(){$this->sqlBuilder=clone$this->sqlBuilder;}function
getConnection(){return$this->connection;}function
getDatabaseReflection(){return$this->reflection;}function
getName(){return$this->name;}function
getPrimary($need=TRUE){if($this->primary===NULL&&$need){throw
new\LogicException("Table \"{$this->name}\" does not have a primary key.");}return$this->primary;}function
getPrimarySequence(){if($this->primarySequence===FALSE){$this->primarySequence=NULL;$driver=$this->connection->getSupplementalDriver();if($driver->isSupported(ISupplementalDriver::SUPPORT_SEQUENCE)&&$this->primary!==NULL){foreach($driver->getColumns($this->name)as$column){if($column['name']===$this->primary){$this->primarySequence=$column['vendor']['sequence'];break;}}}}return$this->primarySequence;}function
setPrimarySequence($sequence){$this->primarySequence=$sequence;return$this;}function
getSql(){return$this->sqlBuilder->buildSelectQuery($this->getPreviousAccessedColumns());}function
getPreviousAccessedColumns(){if($this->cache&&$this->previousAccessedColumns===NULL){$this->accessedColumns=$this->previousAccessedColumns=$this->cache->load($this->getGeneralCacheKey());if($this->previousAccessedColumns===NULL){$this->previousAccessedColumns=array();}}return
array_keys(array_filter((array)$this->previousAccessedColumns));}function
getSqlBuilder(){return$this->sqlBuilder;}function
get($key){$clone=clone$this;return$clone->wherePrimary($key)->fetch();}function
fetch(){$this->execute();$return=current($this->data);next($this->data);return$return;}function
fetchPairs($key,$value=NULL){$return=array();foreach($this
as$row){$return[is_object($row[$key])?(string)$row[$key]:$row[$key]]=($value===NULL?$row:$row[$value]);}return$return;}function
fetchAll(){return
iterator_to_array($this);}function
select($columns){$this->emptyResultSet();call_user_func_array(array($this->sqlBuilder,'addSelect'),func_get_args());return$this;}function
find($key){trigger_error(__METHOD__.'() is deprecated; use $selection->wherePrimary() instead.',E_USER_DEPRECATED);return$this->wherePrimary($key);}function
wherePrimary($key){if(is_array($this->primary)&&Nette\Utils\Arrays::isList($key)){if(isset($key[0])&&is_array($key[0])){$this->where($this->primary,$key);}else{foreach($this->primary
as$i=>$primary){$this->where($this->name.'.'.$primary,$key[$i]);}}}elseif(is_array($key)&&!Nette\Utils\Arrays::isList($key)){$this->where($key);}else{$this->where($this->name.'.'.$this->getPrimary(),$key);}return$this;}function
where($condition,$parameters=array()){if(is_array($condition)&&$parameters===array()){foreach($condition
as$key=>$val){if(is_int($key)){$this->where($val);}else{$this->where($key,$val);}}return$this;}$this->emptyResultSet();call_user_func_array(array($this->sqlBuilder,'addWhere'),func_get_args());return$this;}function
order($columns){$this->emptyResultSet();call_user_func_array(array($this->sqlBuilder,'addOrder'),func_get_args());return$this;}function
limit($limit,$offset=NULL){$this->emptyResultSet();$this->sqlBuilder->setLimit($limit,$offset);return$this;}function
page($page,$itemsPerPage){return$this->limit($itemsPerPage,($page-1)*$itemsPerPage);}function
group($columns){$this->emptyResultSet();if(func_num_args()===2&&strpos($columns,'?')===FALSE){trigger_error('Calling '.__METHOD__.'() with second argument is deprecated; use $selection->having() instead.',E_USER_DEPRECATED);$this->having(func_get_arg(1));$this->sqlBuilder->setGroup($columns);}else{call_user_func_array(array($this->sqlBuilder,'setGroup'),func_get_args());}return$this;}function
having($having){$this->emptyResultSet();call_user_func_array(array($this->sqlBuilder,'setHaving'),func_get_args());return$this;}function
aggregation($function){$selection=$this->createSelectionInstance();$selection->getSqlBuilder()->importConditions($this->getSqlBuilder());$selection->select($function);foreach($selection->fetch()as$val){return$val;}}function
count($column=NULL){if(!$column){$this->execute();return
count($this->data);}return$this->aggregation("COUNT($column)");}function
min($column){return$this->aggregation("MIN($column)");}function
max($column){return$this->aggregation("MAX($column)");}function
sum($column){return$this->aggregation("SUM($column)");}protected
function
execute(){if($this->rows!==NULL){return;}$this->observeCache=$this;if($this->primary===NULL&&$this->sqlBuilder->getSelect()===NULL){throw
new
Nette\InvalidStateException('Table with no primary key requires an explicit select clause.');}try{$result=$this->query($this->getSql());}catch(\PDOException$exception){if(!$this->sqlBuilder->getSelect()&&$this->previousAccessedColumns){$this->previousAccessedColumns=FALSE;$this->accessedColumns=array();$result=$this->query($this->getSql());}else{throw$exception;}}$this->rows=array();$usedPrimary=TRUE;foreach($result->getPdoStatement()as$key=>$row){$row=$this->createRow($result->normalizeRow($row));$primary=$row->getSignature(FALSE);$usedPrimary=$usedPrimary&&$primary;$this->rows[$primary?:$key]=$row;}$this->data=$this->rows;if($usedPrimary&&$this->accessedColumns!==FALSE){foreach((array)$this->primary
as$primary){$this->accessedColumns[$primary]=TRUE;}}}protected
function
createRow(array$row){return
new
ActiveRow($row,$this);}function
createSelectionInstance($table=NULL){return
new
Selection($this->connection,$table?:$this->name,$this->reflection,$this->cache?$this->cache->getStorage():NULL);}protected
function
createGroupedSelectionInstance($table,$column){return
new
GroupedSelection($this,$table,$column);}protected
function
query($query){return$this->connection->queryArgs($query,$this->sqlBuilder->getParameters());}protected
function
emptyResultSet($saveCache=TRUE){if($this->rows!==NULL&&$saveCache){$this->saveCacheState();}$this->rows=NULL;$this->specificCacheKey=NULL;$this->generalCacheKey=NULL;}protected
function
saveCacheState(){if($this->observeCache===$this&&$this->cache&&!$this->sqlBuilder->getSelect()&&$this->accessedColumns!==$this->previousAccessedColumns){$this->cache->save($this->getGeneralCacheKey(),$this->accessedColumns);$this->previousAccessedColumns=NULL;}}protected
function
getRefTable(&$refPath){return$this;}protected
function
loadRefCache(){}protected
function
getGeneralCacheKey(){if($this->generalCacheKey){return$this->generalCacheKey;}return$this->generalCacheKey=md5(serialize(array(__CLASS__,$this->name,$this->sqlBuilder->getConditions())));}protected
function
getSpecificCacheKey(){if($this->specificCacheKey){return$this->specificCacheKey;}return$this->specificCacheKey=md5($this->getSql().json_encode($this->sqlBuilder->getParameters()));}function
accessColumn($key,$selectColumn=TRUE){if(!$this->cache){return;}if($key===NULL){$this->accessedColumns=FALSE;$currentKey=key((array)$this->data);}elseif($this->accessedColumns!==FALSE){$this->accessedColumns[$key]=$selectColumn;}if($selectColumn&&!$this->sqlBuilder->getSelect()&&$this->previousAccessedColumns&&($key===NULL||!isset($this->previousAccessedColumns[$key]))){if($this->sqlBuilder->getLimit()){$generalCacheKey=$this->generalCacheKey;$primaries=array();foreach((array)$this->rows
as$row){$primary=$row->getPrimary();$primaries[]=is_array($primary)?array_values($primary):$primary;}}$this->previousAccessedColumns=array();$this->emptyResultSet(FALSE);if($this->sqlBuilder->getLimit()){$this->sqlBuilder->setLimit(NULL,NULL);$this->wherePrimary($primaries);$this->generalCacheKey=$generalCacheKey;}$this->dataRefreshed=TRUE;if($key===NULL){$this->execute();while(key($this->data)!==$currentKey){next($this->data);}}}}function
removeAccessColumn($key){if($this->cache&&is_array($this->accessedColumns)){$this->accessedColumns[$key]=FALSE;}}function
getDataRefreshed(){return$this->dataRefreshed;}function
insert($data){if($data
instanceof
Selection){$data=new
Nette\Database\SqlLiteral($data->getSql(),$data->getSqlBuilder()->getParameters());}elseif($data
instanceof\Traversable){$data=iterator_to_array($data);}$return=$this->connection->query($this->sqlBuilder->buildInsertQuery(),$data);if($data
instanceof
Nette\Database\SqlLiteral||$this->primary===NULL){return$return->getRowCount();}$primaryKey=$this->connection->getInsertId($this->getPrimarySequence());if(is_array($this->getPrimary())){$primaryKey=array();foreach((array)$this->getPrimary()as$key){if(!isset($data[$key])){return$data;}$primaryKey[$key]=$data[$key];}if(count($primaryKey)===1){$primaryKey=reset($primaryKey);}}$row=$this->createSelectionInstance()->select('*')->wherePrimary($primaryKey)->fetch();$this->loadRefCache();if($this->rows!==NULL){if($signature=$row->getSignature(FALSE)){$this->rows[$signature]=$row;$this->data[$signature]=$row;}else{$this->rows[]=$row;$this->data[]=$row;}}return$row;}function
update($data){if($data
instanceof\Traversable){$data=iterator_to_array($data);}elseif(!is_array($data)){throw
new
Nette\InvalidArgumentException;}if(!$data){return
0;}return$this->connection->queryArgs($this->sqlBuilder->buildUpdateQuery(),array_merge(array($data),$this->sqlBuilder->getParameters()))->getRowCount();}function
delete(){return$this->query($this->sqlBuilder->buildDeleteQuery())->getRowCount();}function
getReferencedTable($table,$column,$checkPrimaryKey){$referenced=&$this->refCache['referenced'][$this->getSpecificCacheKey()]["$table.$column"];$selection=&$referenced['selection'];$cacheKeys=&$referenced['cacheKeys'];if($selection===NULL||!isset($cacheKeys[$checkPrimaryKey])){$this->execute();$cacheKeys=array();foreach($this->rows
as$row){if($row[$column]===NULL){continue;}$key=$row[$column];$cacheKeys[$key]=TRUE;}if($cacheKeys){$selection=$this->createSelectionInstance($table);$selection->where($selection->getPrimary(),array_keys($cacheKeys));}else{$selection=array();}}return$selection;}function
getReferencingTable($table,$column,$active=NULL){$prototype=&$this->refCache['referencingPrototype']["$table.$column"];if(!$prototype){$prototype=$this->createGroupedSelectionInstance($table,$column);$prototype->where("$table.$column",array_keys((array)$this->rows));}$clone=clone$prototype;$clone->setActive($active);return$clone;}function
rewind(){$this->execute();$this->keys=array_keys($this->data);reset($this->keys);}function
current(){if(($key=current($this->keys))!==FALSE){return$this->data[$key];}else{return
FALSE;}}function
key(){return
current($this->keys);}function
next(){next($this->keys);}function
valid(){return
current($this->keys)!==FALSE;}function
offsetSet($key,$value){$this->execute();$this->rows[$key]=$value;}function
offsetGet($key){$this->execute();return$this->rows[$key];}function
offsetExists($key){$this->execute();return
isset($this->rows[$key]);}function
offsetUnset($key){$this->execute();unset($this->rows[$key],$this->data[$key]);}}class
GroupedSelection
extends
Selection{protected$refTable;protected$refCacheCurrent;protected$column;protected$active;function
__construct(Selection$refTable,$table,$column){$this->refTable=$refTable;$this->column=$column;parent::__construct($refTable->connection,$table,$refTable->reflection,$refTable->cache?$refTable->cache->getStorage():NULL);}function
setActive($active){$this->active=$active;return$this;}function
through($column){trigger_error(__METHOD__.'() is deprecated; use '.__CLASS__.'::related("'.$this->name.'", "'.$column.'") instead.',E_USER_DEPRECATED);$this->column=$column;$this->delimitedColumn=$this->refTable->connection->getSupplementalDriver()->delimite($this->column);return$this;}function
select($columns){if(!$this->sqlBuilder->getSelect()){$this->sqlBuilder->addSelect("$this->name.$this->column");}return
parent::select($columns);}function
order($columns){if(!$this->sqlBuilder->getOrder()){$this->sqlBuilder->addOrder("$this->name.$this->column".(preg_match('~\bDESC\z~i',$columns)?' DESC':''));}return
parent::order($columns);}function
aggregation($function){$aggregation=&$this->getRefTable($refPath)->aggregation[$refPath.$function.$this->getSql().json_encode($this->sqlBuilder->getParameters())];if($aggregation===NULL){$aggregation=array();$selection=$this->createSelectionInstance();$selection->getSqlBuilder()->importConditions($this->getSqlBuilder());$selection->select($function);$selection->select("$this->name.$this->column");$selection->group("$this->name.$this->column");foreach($selection
as$row){$aggregation[$row[$this->column]]=$row;}}if(isset($aggregation[$this->active])){foreach($aggregation[$this->active]as$val){return$val;}}}function
count($column=NULL){$return=parent::count($column);return
isset($return)?$return:0;}protected
function
execute(){if($this->rows!==NULL){$this->observeCache=$this;return;}$accessedColumns=$this->accessedColumns;$this->loadRefCache();if(!isset($this->refCacheCurrent['data'])){$this->accessedColumns=$accessedColumns;$limit=$this->sqlBuilder->getLimit();$rows=count($this->refTable->rows);if($limit&&$rows>1){$this->sqlBuilder->setLimit(NULL,NULL);}parent::execute();$this->sqlBuilder->setLimit($limit,NULL);$data=array();$offset=array();$this->accessColumn($this->column);foreach((array)$this->rows
as$key=>$row){$ref=&$data[$row[$this->column]];$skip=&$offset[$row[$this->column]];if($limit===NULL||$rows<=1||(count($ref)<$limit&&$skip>=$this->sqlBuilder->getOffset())){$ref[$key]=$row;}else{unset($this->rows[$key]);}$skip++;unset($ref,$skip);}$this->refCacheCurrent['data']=$data;$this->data=&$this->refCacheCurrent['data'][$this->active];}$this->observeCache=$this;if($this->data===NULL){$this->data=array();}else{foreach($this->data
as$row){$row->setTable($this);}reset($this->data);}}protected
function
getRefTable(&$refPath){$refObj=$this->refTable;$refPath=$this->name.'.';while($refObj
instanceof
GroupedSelection){$refPath.=$refObj->name.'.';$refObj=$refObj->refTable;}return$refObj;}protected
function
loadRefCache(){$hash=$this->getSpecificCacheKey();$referencing=&$this->refCache['referencing'][$this->getGeneralCacheKey()];$this->observeCache=&$referencing['observeCache'];$this->refCacheCurrent=&$referencing[$hash];$this->accessedColumns=&$referencing[$hash]['accessed'];$this->specificCacheKey=&$referencing[$hash]['specificCacheKey'];$this->rows=&$referencing[$hash]['rows'];if(isset($referencing[$hash]['data'][$this->active])){$this->data=&$referencing[$hash]['data'][$this->active];}}function
insert($data){if($data
instanceof\Traversable&&!$data
instanceof
Selection){$data=iterator_to_array($data);}if(Nette\Utils\Arrays::isList($data)){foreach(array_keys($data)as$key){$data[$key][$this->column]=$this->active;}}else{$data[$this->column]=$this->active;}return
parent::insert($data);}function
update($data){$builder=$this->sqlBuilder;$this->sqlBuilder=clone$this->sqlBuilder;$this->where($this->column,$this->active);$return=parent::update($data);$this->sqlBuilder=$builder;return$return;}function
delete(){$builder=$this->sqlBuilder;$this->sqlBuilder=clone$this->sqlBuilder;$this->where($this->column,$this->active);$return=parent::delete();$this->sqlBuilder=$builder;return$return;}}use
Nette\Database\Connection;use
Nette\Database\IReflection;use
Nette\Database\SqlLiteral;class
SqlBuilder
extends
Nette\Object{private$driver;protected$tableName;protected$databaseReflection;protected$delimitedTable;protected$select=array();protected$where=array();protected$conditions=array();protected$parameters=array('select'=>array(),'where'=>array(),'group'=>array(),'having'=>array(),'order'=>array());protected$order=array();protected$limit=NULL;protected$offset=NULL;protected$group='';protected$having='';function
__construct($tableName,Connection$connection,IReflection$reflection){$this->tableName=$tableName;$this->databaseReflection=$reflection;$this->driver=$connection->getSupplementalDriver();$this->delimitedTable=$this->tryDelimite($tableName);}function
buildInsertQuery(){return"INSERT INTO {$this->delimitedTable}";}function
buildUpdateQuery(){if($this->limit!==NULL||$this->offset){throw
new
Nette\NotSupportedException('LIMIT clause is not supported in UPDATE query.');}return$this->tryDelimite("UPDATE {$this->tableName} SET ?".$this->buildConditions());}function
buildDeleteQuery(){if($this->limit!==NULL||$this->offset){throw
new
Nette\NotSupportedException('LIMIT clause is not supported in DELETE query.');}return$this->tryDelimite("DELETE FROM {$this->tableName}".$this->buildConditions());}function
buildSelectQuery($columns=NULL){$queryCondition=$this->buildConditions();$queryEnd=$this->buildQueryEnd();$joins=array();$this->parseJoins($joins,$queryCondition);$this->parseJoins($joins,$queryEnd);if($this->select){$querySelect=$this->buildSelect($this->select);$this->parseJoins($joins,$querySelect);}elseif($columns){$prefix=$joins?"{$this->delimitedTable}.":'';$cols=array();foreach($columns
as$col){$cols[]=$prefix.$col;}$querySelect=$this->buildSelect($cols);}elseif($this->group&&!$this->driver->isSupported(ISupplementalDriver::SUPPORT_SELECT_UNGROUPED_COLUMNS)){$querySelect=$this->buildSelect(array($this->group));$this->parseJoins($joins,$querySelect);}else{$prefix=$joins?"{$this->delimitedTable}.":'';$querySelect=$this->buildSelect(array($prefix.'*'));}$queryJoins=$this->buildQueryJoins($joins);$query="{$querySelect} FROM {$this->tableName}{$queryJoins}{$queryCondition}{$queryEnd}";if($this->limit!==NULL||$this->offset){$this->driver->applyLimit($query,$this->limit,$this->offset);}return$this->tryDelimite($query);}function
getParameters(){return
array_merge($this->parameters['select'],$this->parameters['where'],$this->parameters['group'],$this->parameters['having'],$this->parameters['order']);}function
importConditions(SqlBuilder$builder){$this->where=$builder->where;$this->parameters['where']=$builder->parameters['where'];$this->conditions=$builder->conditions;}function
addSelect($columns){if(is_array($columns)){throw
new
Nette\InvalidArgumentException('Select column must be a string.');}$this->select[]=$columns;$this->parameters['select']=array_merge($this->parameters['select'],array_slice(func_get_args(),1));}function
getSelect(){return$this->select;}function
addWhere($condition,$parameters=array()){if(is_array($condition)&&is_array($parameters)&&!empty($parameters)){return$this->addWhereComposition($condition,$parameters);}$args=func_get_args();$hash=md5(json_encode($args));if(isset($this->conditions[$hash])){return
FALSE;}$this->conditions[$hash]=$condition;$placeholderCount=substr_count($condition,'?');if($placeholderCount>1&&count($args)===2&&is_array($parameters)){$args=$parameters;}else{array_shift($args);}$condition=trim($condition);if($placeholderCount===0&&count($args)===1){$condition.=' ?';}elseif($placeholderCount!==count($args)){throw
new
Nette\InvalidArgumentException('Argument count does not match placeholder count.');}$replace=NULL;$placeholderNum=0;foreach($args
as$arg){preg_match('#(?:.*?\?.*?){'.$placeholderNum.'}(((?:&|\||^|~|\+|-|\*|/|%|\(|,|<|>|=|(?<=\W|^)(?:ALL|AND|ANY|BETWEEN|EXISTS|IN|LIKE|OR|NOT|SOME))\s*)?\?)#s',$condition,$match,PREG_OFFSET_CAPTURE);$hasOperator=($match[1][0]==='?'&&$match[1][1]===0)?TRUE:!empty($match[2][0]);if($arg===NULL){if($hasOperator){throw
new
Nette\InvalidArgumentException('Column operator does not accept NULL argument.');}$replace='IS NULL';}elseif(is_array($arg)||$arg
instanceof
Selection){if($hasOperator){if(trim($match[2][0])==='NOT'){$match[2][0]=rtrim($match[2][0]).' IN ';}elseif(trim($match[2][0])!=='IN'){throw
new
Nette\InvalidArgumentException('Column operator does not accept array argument.');}}else{$match[2][0]='IN ';}if($arg
instanceof
Selection){$clone=clone$arg;if(!$clone->getSqlBuilder()->select){try{$clone->select($clone->getPrimary());}catch(\LogicException$e){throw
new
Nette\InvalidArgumentException('Selection argument must have defined a select column.',0,$e);}}if($this->driver->isSupported(ISupplementalDriver::SUPPORT_SUBSELECT)){$arg=NULL;$replace=$match[2][0].'('.$clone->getSql().')';$this->parameters['where']=array_merge($this->parameters['where'],$clone->getSqlBuilder()->parameters['where']);}else{$arg=array();foreach($clone
as$row){$arg[]=array_values(iterator_to_array($row));}}}if($arg!==NULL){if(!$arg){$hasBrackets=strpos($condition,'(')!==FALSE;$hasOperators=preg_match('#AND|OR#',$condition);$hasNot=strpos($condition,'NOT')!==FALSE;$hasPrefixNot=strpos($match[2][0],'NOT')!==FALSE;if(!$hasBrackets&&($hasOperators||($hasNot&&!$hasPrefixNot))){throw
new
Nette\InvalidArgumentException('Possible SQL query corruption. Add parentheses around operators.');}if($hasPrefixNot){$replace='IS NULL OR TRUE';}else{$replace='IS NULL AND FALSE';}$arg=NULL;}else{$replace=$match[2][0].'(?)';$this->parameters['where'][]=$arg;}}}elseif($arg
instanceof
SqlLiteral){$this->parameters['where'][]=$arg;}else{if($hasOperator){$replace=$match[2][0].'?';}else{$replace='= ?';}$this->parameters['where'][]=$arg;}if($replace){$condition=substr_replace($condition,$replace,$match[1][1],strlen($match[1][0]));$replace=NULL;}if($arg!==NULL){$placeholderNum++;}}$this->where[]=$condition;return
TRUE;}function
getConditions(){return
array_values($this->conditions);}function
addOrder($columns){$this->order[]=$columns;$this->parameters['order']=array_merge($this->parameters['order'],array_slice(func_get_args(),1));}function
getOrder(){return$this->order;}function
setLimit($limit,$offset){$this->limit=$limit;$this->offset=$offset;}function
getLimit(){return$this->limit;}function
getOffset(){return$this->offset;}function
setGroup($columns){$this->group=$columns;$this->parameters['group']=array_slice(func_get_args(),1);}function
getGroup(){return$this->group;}function
setHaving($having){$this->having=$having;$this->parameters['having']=array_slice(func_get_args(),1);}function
getHaving(){return$this->having;}protected
function
buildSelect(array$columns){return'SELECT '.implode(', ',$columns);}protected
function
parseJoins(&$joins,&$query){$builder=$this;$query=preg_replace_callback('~
			(?(DEFINE)
				(?P<word> [a-z][\w_]* )
				(?P<del> [.:] )
				(?P<node> (?&del)? (?&word) )
			)
			(?P<chain> (?!\.) (?&node)*)  \. (?P<column> (?&word) | \*  )
		~xi',function($match)use(&$joins,$builder){return$builder->parseJoinsCb($joins,$match);},$query);}function
parseJoinsCb(&$joins,$match){$chain=$match['chain'];if(!empty($chain[0])&&($chain[0]!=='.'||$chain[0]!==':')){$chain='.'.$chain;}$parent=$parentAlias=$this->tableName;if($chain==".{$parent}"){return"{$parent}.{$match['column']}";}preg_match_all('~
			(?(DEFINE)
				(?P<word> [a-z][\w_]* )
			)
			(?P<del> [.:])?(?P<key> (?&word))
		~xi',$chain,$keyMatches,PREG_SET_ORDER);foreach($keyMatches
as$keyMatch){if($keyMatch['del']===':'){list($table,$primary)=$this->databaseReflection->getHasManyReference($parent,$keyMatch['key']);$column=$this->databaseReflection->getPrimary($parent);}else{list($table,$column)=$this->databaseReflection->getBelongsToReference($parent,$keyMatch['key']);$primary=$this->databaseReflection->getPrimary($table);}$joins[$table.$column]=array($table,$keyMatch['key']?:$table,$parentAlias,$column,$primary);$parent=$table;$parentAlias=$keyMatch['key'];}return($keyMatch['key']?:$table).".{$match['column']}";}protected
function
buildQueryJoins(array$joins){$return='';foreach($joins
as$join){list($joinTable,$joinAlias,$table,$tableColumn,$joinColumn)=$join;$return.=" LEFT JOIN {$joinTable}".($joinTable!==$joinAlias?" AS {$joinAlias}":'')." ON {$table}.{$tableColumn} = {$joinAlias}.{$joinColumn}";}return$return;}protected
function
buildConditions(){return$this->where?' WHERE ('.implode(') AND (',$this->where).')':'';}protected
function
buildQueryEnd(){$return='';if($this->group){$return.=' GROUP BY '.$this->group;}if($this->having){$return.=' HAVING '.$this->having;}if($this->order){$return.=' ORDER BY '.implode(', ',$this->order);}return$return;}protected
function
tryDelimite($s){$driver=$this->driver;return
preg_replace_callback('#(?<=[^\w`"\[]|^)[a-z_][a-z0-9_]*(?=[^\w`"(\]]|\z)#i',function($m)use($driver){return
strtoupper($m[0])===$m[0]?$m[0]:$driver->delimite($m[0]);},$s);}protected
function
addWhereComposition(array$columns,array$parameters){if($this->driver->isSupported(ISupplementalDriver::SUPPORT_MULTI_COLUMN_AS_OR_COND)){$conditionFragment='('.implode(' = ? AND ',$columns).' = ?) OR ';$condition=substr(str_repeat($conditionFragment,count($parameters)),0,-4);return$this->addWhere($condition,Nette\Utils\Arrays::flatten($parameters));}else{return$this->addWhere('('.implode(', ',$columns).') IN',$parameters);}}}}namespace Nette\DI{use
Nette;use
Nette\Utils\Validators;class
Compiler
extends
Nette\Object{private$extensions=array();private$container;private$config;private
static$reserved=array('services'=>1,'factories'=>1,'parameters'=>1);function
addExtension($name,CompilerExtension$extension){if(isset(self::$reserved[$name])){throw
new
Nette\InvalidArgumentException("Name '$name' is reserved.");}$this->extensions[$name]=$extension->setCompiler($this,$name);return$this;}function
getExtensions(){return$this->extensions;}function
getContainerBuilder(){return$this->container;}function
getConfig(){return$this->config;}function
compile(array$config,$className,$parentName){$this->config=$config;$this->container=new
ContainerBuilder;$this->processParameters();$this->processExtensions();$this->processServices();return$this->generateCode($className,$parentName);}function
processParameters(){if(isset($this->config['parameters'])){$this->container->parameters=Helpers::expand($this->config['parameters'],$this->config['parameters'],TRUE);}}function
processExtensions(){for($i=0;$slice=array_slice($this->extensions,$i,1,TRUE);$i++){$name=key($slice);if(isset($this->config[$name])){$this->config[$name]=$this->container->expand($this->config[$name]);}$this->extensions[$name]->loadConfiguration();}if($extra=array_diff_key($this->config,self::$reserved,$this->extensions)){$extra=implode("', '",array_keys($extra));throw
new
Nette\InvalidStateException("Found sections '$extra' in configuration, but corresponding extensions are missing.");}}function
processServices(){$this->parseServices($this->container,$this->config);foreach($this->extensions
as$name=>$extension){if(isset($this->config[$name])){$this->parseServices($this->container,$this->config[$name],$name);}}}function
generateCode($className,$parentName){foreach($this->extensions
as$extension){$extension->beforeCompile();$this->container->addDependency(Nette\Reflection\ClassType::from($extension)->getFileName());}$classes=$this->container->generateClasses();$classes[0]->setName($className)->setExtends($parentName)->addMethod('initialize');foreach($this->extensions
as$extension){$extension->afterCompile($classes[0]);}return
implode("\n\n\n",$classes);}static
function
parseServices(ContainerBuilder$container,array$config,$namespace=NULL){$services=isset($config['services'])?$config['services']:array();$factories=isset($config['factories'])?$config['factories']:array();$all=array_merge($services,$factories);uasort($all,function($a,$b){return
strcmp(Config\Helpers::isInheriting($a),Config\Helpers::isInheriting($b));});foreach($all
as$origName=>$def){$shared=array_key_exists($origName,$services);if((string)(int)$origName===(string)$origName){$name=count($container->getDefinitions()).preg_replace('#\W+#','_',$def
instanceof\stdClass?".$def->value":(is_scalar($def)?".$def":''));}elseif($shared&&array_key_exists($origName,$factories)){throw
new
ServiceCreationException("It is not allowed to use services and factories with the same name: '$origName'.");}else{$name=($namespace?$namespace.'.':'').strtr($origName,'\\','_');}$params=$container->parameters;if(is_array($def)&&isset($def['parameters'])){foreach((array)$def['parameters']as$k=>$v){$v=explode(' ',is_int($k)?$v:$k);$params[end($v)]=$container::literal('$'.end($v));}}$def=Helpers::expand($def,$params);if(($parent=Config\Helpers::takeParent($def))&&$parent!==$name){$container->removeDefinition($name);$definition=$container->addDefinition($name,$parent===Config\Helpers::OVERWRITE?NULL:unserialize(serialize($container->getDefinition($parent))));}elseif($container->hasDefinition($name)){$definition=$container->getDefinition($name);if($definition->shared!==$shared){throw
new
ServiceCreationException("It is not allowed to use service and factory with the same name '$name'.");}}else{$definition=$container->addDefinition($name);}try{static::parseService($definition,$def,$shared);}catch(\Exception$e){throw
new
ServiceCreationException("Service '$name': ".$e->getMessage(),NULL,$e);}if($definition->class==='self'){$definition->class=$origName;}if($definition->factory&&$definition->factory->entity==='self'){$definition->factory->entity=$origName;}}}static
function
parseService(ServiceDefinition$definition,$config,$shared=TRUE){if($config===NULL){return;}elseif(!$shared&&is_string($config)&&interface_exists($config)){$config=array('class'=>NULL,'implement'=>$config);}elseif(!$shared&&$config
instanceof\stdClass&&interface_exists($config->value)){$config=array('class'=>NULL,'implement'=>$config->value,'factory'=>array_shift($config->attributes));}elseif(!is_array($config)){$config=array('class'=>NULL,'create'=>$config);}if(array_key_exists('factory',$config)){$config['create']=$config['factory'];unset($config['factory']);};$known=$shared?array('class','create','arguments','setup','autowired','inject','run','tags'):array('class','create','arguments','setup','autowired','inject','parameters','implement');if($error=array_diff(array_keys($config),$known)){throw
new
Nette\InvalidStateException("Unknown or deprecated key '".implode("', '",$error)."' in definition of service.");}$arguments=array();if(array_key_exists('arguments',$config)){Validators::assertField($config,'arguments','array');$arguments=self::filterArguments($config['arguments']);$definition->setArguments($arguments);}if(array_key_exists('class',$config)||array_key_exists('create',$config)){$definition->class=NULL;$definition->factory=NULL;}if(array_key_exists('class',$config)){Validators::assertField($config,'class','string|stdClass|null');if($config['class']instanceof\stdClass){$definition->setClass($config['class']->value,self::filterArguments($config['class']->attributes));}else{$definition->setClass($config['class'],$arguments);}}if(array_key_exists('create',$config)){Validators::assertField($config,'create','callable|stdClass|null');if($config['create']instanceof\stdClass){$definition->setFactory($config['create']->value,self::filterArguments($config['create']->attributes));}else{$definition->setFactory($config['create'],$arguments);}}if(isset($config['setup'])){if(Config\Helpers::takeParent($config['setup'])){$definition->setup=array();}Validators::assertField($config,'setup','list');foreach($config['setup']as$id=>$setup){Validators::assert($setup,'callable|stdClass',"setup item #$id");if($setup
instanceof\stdClass){Validators::assert($setup->value,'callable',"setup item #$id");$definition->addSetup($setup->value,self::filterArguments($setup->attributes));}else{$definition->addSetup($setup);}}}$definition->setShared($shared);if(isset($config['parameters'])){Validators::assertField($config,'parameters','array');$definition->setParameters($config['parameters']);}if(isset($config['implement'])){Validators::assertField($config,'implement','string');$definition->setImplement($config['implement']);$definition->setAutowired(TRUE);}if(isset($config['autowired'])){Validators::assertField($config,'autowired','bool');$definition->setAutowired($config['autowired']);}if(isset($config['inject'])){Validators::assertField($config,'inject','bool');$definition->setInject($config['inject']);}if(isset($config['run'])){$config['tags']['run']=(bool)$config['run'];}if(isset($config['tags'])){Validators::assertField($config,'tags','array');if(Config\Helpers::takeParent($config['tags'])){$definition->tags=array();}foreach($config['tags']as$tag=>$attrs){if(is_int($tag)&&is_string($attrs)){$definition->addTag($attrs);}else{$definition->addTag($tag,$attrs);}}}}static
function
filterArguments(array$args){foreach($args
as$k=>$v){if($v==='...'){unset($args[$k]);}elseif($v
instanceof\stdClass&&isset($v->value,$v->attributes)){$args[$k]=new
Statement($v->value,self::filterArguments($v->attributes));}}return$args;}}abstract
class
CompilerExtension
extends
Nette\Object{protected$compiler;protected$name;function
setCompiler(Compiler$compiler,$name){$this->compiler=$compiler;$this->name=$name;return$this;}function
getConfig(array$defaults=NULL){$config=$this->compiler->getConfig();$config=isset($config[$this->name])?$config[$this->name]:array();unset($config['services'],$config['factories']);return
Config\Helpers::merge($config,$this->compiler->getContainerBuilder()->expand($defaults));}function
getContainerBuilder(){return$this->compiler->getContainerBuilder();}function
loadFromFile($file){$loader=new
Config\Loader;$res=$loader->load($file);$container=$this->compiler->getContainerBuilder();foreach($loader->getDependencies()as$file){$container->addDependency($file);}return$res;}function
prefix($id){return
substr_replace($id,$this->name.'.',substr($id,0,1)==='@'?1:0,0);}function
loadConfiguration(){}function
beforeCompile(){}function
afterCompile(Nette\PhpGenerator\ClassType$class){}}}namespace Nette\DI\Config\Adapters{use
Nette;use
Nette\DI\Config\Helpers;class
IniAdapter
extends
Nette\Object
implements
Nette\DI\Config\IAdapter{const
INHERITING_SEPARATOR='<',KEY_SEPARATOR='.',ESCAPED_KEY_SEPARATOR='..',RAW_SECTION='!';function
load($file){$ini=@parse_ini_file($file,TRUE);if($ini===FALSE){$error=error_get_last();throw
new
Nette\InvalidStateException("parse_ini_file(): $error[message]");}$data=array();foreach($ini
as$secName=>$secData){if(is_array($secData)){if(substr($secName,-1)===self::RAW_SECTION){$secName=substr($secName,0,-1);}else{$tmp=array();foreach($secData
as$key=>$val){$cursor=&$tmp;$key=str_replace(self::ESCAPED_KEY_SEPARATOR,"\xFF",$key);foreach(explode(self::KEY_SEPARATOR,$key)as$part){$part=str_replace("\xFF",self::KEY_SEPARATOR,$part);if(!isset($cursor[$part])||is_array($cursor[$part])){$cursor=&$cursor[$part];}else{throw
new
Nette\InvalidStateException("Invalid key '$key' in section [$secName] in file '$file'.");}}$cursor=$val;}$secData=$tmp;}$parts=explode(self::INHERITING_SEPARATOR,$secName);if(count($parts)>1){$secName=trim($parts[0]);$secData[Helpers::EXTENDS_KEY]=trim($parts[1]);}}$cursor=&$data;foreach(explode(self::KEY_SEPARATOR,$secName)as$part){if(!isset($cursor[$part])||is_array($cursor[$part])){$cursor=&$cursor[$part];}else{throw
new
Nette\InvalidStateException("Invalid section [$secName] in file '$file'.");}}if(is_array($secData)&&is_array($cursor)){$secData=Helpers::merge($secData,$cursor);}$cursor=$secData;}return$data;}function
dump(array$data){$output=array();foreach($data
as$name=>$secData){if(!is_array($secData)){$output=array();self::build($data,$output,'');break;}if($parent=Helpers::takeParent($secData)){$output[]="[$name ".self::INHERITING_SEPARATOR." $parent]";}else{$output[]="[$name]";}self::build($secData,$output,'');$output[]='';}return"; generated by Nette\n\n".implode(PHP_EOL,$output);}private
static
function
build($input,&$output,$prefix){foreach($input
as$key=>$val){$key=str_replace(self::KEY_SEPARATOR,self::ESCAPED_KEY_SEPARATOR,$key);if(is_array($val)){self::build($val,$output,$prefix.$key.self::KEY_SEPARATOR);}elseif(is_bool($val)){$output[]="$prefix$key = ".($val?'true':'false');}elseif(is_numeric($val)){$output[]="$prefix$key = $val";}elseif(is_string($val)){$output[]="$prefix$key = \"$val\"";}else{throw
new
Nette\InvalidArgumentException("The '$prefix$key' item must be scalar or array, ".gettype($val)." given.");}}}}use
Nette\Utils\Neon;class
NeonAdapter
extends
Nette\Object
implements
Nette\DI\Config\IAdapter{const
INHERITING_SEPARATOR='<',PREVENT_MERGING='!';function
load($file){return$this->process((array)Neon::decode(file_get_contents($file)));}private
function
process(array$arr){$res=array();foreach($arr
as$key=>$val){if(substr($key,-1)===self::PREVENT_MERGING){if(!is_array($val)&&$val!==NULL){throw
new
Nette\InvalidStateException("Replacing operator is available only for arrays, item '$key' is not array.");}$key=substr($key,0,-1);$val[Helpers::EXTENDS_KEY]=Helpers::OVERWRITE;}elseif(preg_match('#^(\S+)\s+'.self::INHERITING_SEPARATOR.'\s+(\S+)\z#',$key,$matches)){if(!is_array($val)&&$val!==NULL){throw
new
Nette\InvalidStateException("Inheritance operator is available only for arrays, item '$key' is not array.");}list(,$key,$val[Helpers::EXTENDS_KEY])=$matches;if(isset($res[$key])){throw
new
Nette\InvalidStateException("Duplicated key '$key'.");}}if(is_array($val)){$val=$this->process($val);}elseif($val
instanceof
Nette\Utils\NeonEntity){$val=(object)array('value'=>$val->value,'attributes'=>$this->process($val->attributes));}$res[$key]=$val;}return$res;}function
dump(array$data){$tmp=array();foreach($data
as$name=>$secData){if($parent=Helpers::takeParent($secData)){$name.=' '.self::INHERITING_SEPARATOR.' '.$parent;}$tmp[$name]=$secData;}return"# generated by Nette\n\n".Neon::encode($tmp,Neon::BLOCK);}}class
PhpAdapter
extends
Nette\Object
implements
Nette\DI\Config\IAdapter{function
load($file){return
Nette\Utils\LimitedScope::load($file);}function
dump(array$data){return"<?php // generated by Nette \nreturn ".Nette\PhpGenerator\Helpers::dump($data).';';}}}namespace Nette\DI\Config{use
Nette;class
Helpers{const
EXTENDS_KEY='_extends',OVERWRITE=TRUE;static
function
merge($left,$right){if(is_array($left)&&is_array($right)){foreach($left
as$key=>$val){if(is_int($key)){$right[]=$val;}else{if(is_array($val)&&isset($val[self::EXTENDS_KEY])){if($val[self::EXTENDS_KEY]===self::OVERWRITE){unset($val[self::EXTENDS_KEY]);}}elseif(isset($right[$key])){$val=static::merge($val,$right[$key]);}$right[$key]=$val;}}return$right;}elseif($left===NULL&&is_array($right)){return$right;}else{return$left;}}static
function
takeParent(&$data){if(is_array($data)&&isset($data[self::EXTENDS_KEY])){$parent=$data[self::EXTENDS_KEY];unset($data[self::EXTENDS_KEY]);return$parent;}}static
function
isOverwriting(&$data){return
is_array($data)&&isset($data[self::EXTENDS_KEY])&&$data[self::EXTENDS_KEY]===self::OVERWRITE;}static
function
isInheriting(&$data){return
is_array($data)&&isset($data[self::EXTENDS_KEY])&&$data[self::EXTENDS_KEY]!==self::OVERWRITE;}}use
Nette\Utils\Validators;class
Loader
extends
Nette\Object{const
INCLUDES_KEY='includes';private$adapters=array('php'=>'Nette\DI\Config\Adapters\PhpAdapter','ini'=>'Nette\DI\Config\Adapters\IniAdapter','neon'=>'Nette\DI\Config\Adapters\NeonAdapter');private$dependencies=array();function
load($file,$section=NULL){if(!is_file($file)||!is_readable($file)){throw
new
Nette\FileNotFoundException("File '$file' is missing or is not readable.");}$this->dependencies[]=$file=realpath($file);$data=$this->getAdapter($file)->load($file);if($section){if(isset($data[self::INCLUDES_KEY])){throw
new
Nette\InvalidStateException("Section 'includes' must be placed under some top section in file '$file'.");}$data=$this->getSection($data,$section,$file);}$merged=array();if(isset($data[self::INCLUDES_KEY])){Validators::assert($data[self::INCLUDES_KEY],'list',"section 'includes' in file '$file'");foreach($data[self::INCLUDES_KEY]as$include){$merged=Helpers::merge($this->load(dirname($file).'/'.$include),$merged);}}unset($data[self::INCLUDES_KEY]);return
Helpers::merge($data,$merged);}function
save($data,$file){if(file_put_contents($file,$this->getAdapter($file)->dump($data))===FALSE){throw
new
Nette\IOException("Cannot write file '$file'.");}}function
getDependencies(){return
array_unique($this->dependencies);}function
addAdapter($extension,$adapter){$this->adapters[strtolower($extension)]=$adapter;return$this;}private
function
getAdapter($file){$extension=strtolower(pathinfo($file,PATHINFO_EXTENSION));if(!isset($this->adapters[$extension])){throw
new
Nette\InvalidArgumentException("Unknown file extension '$file'.");}return
is_object($this->adapters[$extension])?$this->adapters[$extension]:new$this->adapters[$extension];}private
function
getSection(array$data,$key,$file){Validators::assertField($data,$key,'array|null',"section '%' in file '$file'");$item=$data[$key];if($parent=Helpers::takeParent($item)){$item=Helpers::merge($item,$this->getSection($data,$parent,$file));}return$item;}}}namespace Nette\DI{use
Nette;class
Container
extends
Nette\Object{const
TAGS='tags';const
TYPES='types';public$parameters=array();private$registry=array();protected$meta=array();private$creating;function
__construct(array$params=array()){$this->parameters=$params+$this->parameters;}function
getParameters(){return$this->parameters;}function
addService($name,$service){if(func_num_args()>2){throw
new
Nette\DeprecatedException('Parameter $meta has been removed.');}elseif(!is_string($name)||!$name){throw
new
Nette\InvalidArgumentException('Service name must be a non-empty string, '.gettype($name).' given.');}elseif(isset($this->registry[$name])){throw
new
Nette\InvalidStateException("Service '$name' already exists.");}elseif(is_string($service)||is_array($service)||$service
instanceof\Closure||$service
instanceof
Nette\Callback){trigger_error('Passing factories to '.__METHOD__.'() is deprecated; pass the object itself.',E_USER_DEPRECATED);$service=is_string($service)&&!preg_match('#\x00|:#',$service)?new$service:call_user_func($service,$this);}if(!is_object($service)){throw
new
Nette\InvalidArgumentException('Service must be a object, '.gettype($service).' given.');}$this->registry[$name]=$service;return$this;}function
removeService($name){unset($this->registry[$name]);}function
getService($name){if(!isset($this->registry[$name])){$this->registry[$name]=$this->createService($name);}return$this->registry[$name];}function
hasService($name){return
isset($this->registry[$name])||method_exists($this,$method=Container::getMethodName($name))&&$this->getReflection()->getMethod($method)->getName()===$method;}function
isCreated($name){if(!$this->hasService($name)){throw
new
MissingServiceException("Service '$name' not found.");}return
isset($this->registry[$name]);}function
createService($name,array$args=array()){$method=Container::getMethodName($name);if(isset($this->creating[$name])){throw
new
Nette\InvalidStateException("Circular reference detected for services: ".implode(', ',array_keys($this->creating)).".");}elseif(!method_exists($this,$method)||$this->getReflection()->getMethod($method)->getName()!==$method){throw
new
MissingServiceException("Service '$name' not found.");}$this->creating[$name]=TRUE;try{$service=call_user_func_array(array($this,$method),$args);}catch(\Exception$e){unset($this->creating[$name]);throw$e;}unset($this->creating[$name]);if(!is_object($service)){throw
new
Nette\UnexpectedValueException("Unable to create service '$name', value returned by method $method() is not object.");}return$service;}function
getByType($class,$need=TRUE){$names=$this->findByType($class);if(!$names){if($need){throw
new
MissingServiceException("Service of type $class not found.");}}elseif(count($names)>1){throw
new
MissingServiceException("Multiple services of type $class found: ".implode(', ',$names).'.');}else{return$this->getService($names[0]);}}function
findByType($class){$class=ltrim(strtolower($class),'\\');return
isset($this->meta[self::TYPES][$class])?$this->meta[self::TYPES][$class]:array();}function
findByTag($tag){return
isset($this->meta[self::TAGS][$tag])?$this->meta[self::TAGS][$tag]:array();}function
createInstance($class,array$args=array()){$rc=Nette\Reflection\ClassType::from($class);if(!$rc->isInstantiable()){throw
new
ServiceCreationException("Class $class is not instantiable.");}elseif($constructor=$rc->getConstructor()){return$rc->newInstanceArgs(Helpers::autowireArguments($constructor,$args,$this));}elseif($args){throw
new
ServiceCreationException("Unable to pass arguments, class $class has no constructor.");}return
new$class;}function
callInjects($service){if(!is_object($service)){throw
new
Nette\InvalidArgumentException('Service must be object, '.gettype($service).' given.');}foreach(array_reverse(get_class_methods($service))as$method){if(substr($method,0,6)==='inject'){$this->callMethod(array($service,$method));}}foreach(Helpers::getInjectProperties(Nette\Reflection\ClassType::from($service))as$property=>$type){$service->$property=$this->getByType($type);}}function
callMethod($function,array$args=array()){return
call_user_func_array($function,Helpers::autowireArguments(Nette\Utils\Callback::toReflection($function),$args,$this));}function
expand($s){return
Helpers::expand($s,$this->parameters);}function&__get($name){$this->error(__METHOD__,'getService');$tmp=$this->getService($name);return$tmp;}function
__set($name,$service){$this->error(__METHOD__,'addService');$this->addService($name,$service);}function
__isset($name){$this->error(__METHOD__,'hasService');return$this->hasService($name);}function
__unset($name){$this->error(__METHOD__,'removeService');$this->removeService($name);}private
function
error($oldName,$newName){if(empty($this->parameters['container']['accessors'])){trigger_error("$oldName() is deprecated; use $newName() or enable nette.accessors in configuration.",E_USER_DEPRECATED);}}static
function
getMethodName($name){$uname=ucfirst($name);return'createService'.((string)$name===$uname?'__':'').str_replace('.','__',$uname);}}use
Nette\Utils\Validators;use
Nette\Utils\Strings;use
Nette\Reflection;use
Nette\PhpGenerator\Helpers as PhpHelpers;class
ContainerBuilder
extends
Nette\Object{const
THIS_SERVICE='self',THIS_CONTAINER='container';public$parameters=array();private$definitions=array();private$classes;private$dependencies=array();private$generatedClasses=array();public$current;function
addDefinition($name,ServiceDefinition$definition=NULL){if(!is_string($name)||!$name){throw
new
Nette\InvalidArgumentException("Service name must be a non-empty string, ".gettype($name)." given.");}elseif(isset($this->definitions[$name])){throw
new
Nette\InvalidStateException("Service '$name' has already been added.");}return$this->definitions[$name]=$definition?:new
ServiceDefinition;}function
removeDefinition($name){unset($this->definitions[$name]);}function
getDefinition($name){if(!isset($this->definitions[$name])){throw
new
MissingServiceException("Service '$name' not found.");}return$this->definitions[$name];}function
getDefinitions(){return$this->definitions;}function
hasDefinition($name){return
isset($this->definitions[$name]);}function
getByType($class){if($this->current!==NULL&&Reflection\ClassType::from($this->definitions[$this->current]->class)->is($class)){return$this->current;}$lower=ltrim(strtolower($class),'\\');if(!isset($this->classes[$lower])){return;}elseif(count($this->classes[$lower])===1){return$this->classes[$lower][0];}else{throw
new
ServiceCreationException("Multiple services of type $class found: ".implode(', ',$this->classes[$lower]));}}function
findByTag($tag){$found=array();foreach($this->definitions
as$name=>$def){if(isset($def->tags[$tag])&&$def->shared){$found[$name]=$def->tags[$tag];}}return$found;}function
autowireArguments($class,$method,array$arguments){$rc=Reflection\ClassType::from($class);if(!$rc->hasMethod($method)){if(!Nette\Utils\Arrays::isList($arguments)){throw
new
ServiceCreationException("Unable to pass specified arguments to $class::$method().");}return$arguments;}$rm=$rc->getMethod($method);if(!$rm->isPublic()){throw
new
ServiceCreationException("$rm is not callable.");}$this->addDependency($rm->getFileName());return
Helpers::autowireArguments($rm,$arguments,$this);}function
prepareClassList(){$this->classes=FALSE;foreach($this->definitions
as$name=>$def){if(!$def->implement){continue;}if(!interface_exists($def->implement)){throw
new
ServiceCreationException("Interface $def->implement has not been found.");}$rc=Reflection\ClassType::from($def->implement);$method=$rc->hasMethod('create')?$rc->getMethod('create'):($rc->hasMethod('get')?$rc->getMethod('get'):NULL);if(count($rc->getMethods())!==1||!$method||$method->isStatic()){throw
new
ServiceCreationException("Interface $def->implement must have just one non-static method create() or get().");}$def->implement=$rc->getName();if(!$def->class&&empty($def->factory->entity)){$returnType=$method->getAnnotation('return');if(!$returnType){throw
new
ServiceCreationException("Method $method has not @return annotation.");}if(!class_exists($returnType)){if($returnType[0]!=='\\'){$returnType=$rc->getNamespaceName().'\\'.$returnType;}if(!class_exists($returnType)){throw
new
ServiceCreationException("Please use a fully qualified name of class in @return annotation at $method method. Class '$returnType' cannot be found.");}}$def->setClass($returnType);}if($method->getName()==='get'){if($method->getParameters()){throw
new
ServiceCreationException("Method $method must have no arguments.");}if(empty($def->factory->entity)){$def->setFactory('@\\'.ltrim($def->class,'\\'));}elseif(!$this->getServiceName($def->factory->entity)){throw
new
ServiceCreationException("Invalid factory in service '$name' definition.");}}if(!$def->parameters){foreach($method->getParameters()as$param){$paramDef=($param->isArray()?'array':$param->getClassName()).' '.$param->getName();if($param->isOptional()){$def->parameters[$paramDef]=$param->getDefaultValue();}else{$def->parameters[]=$paramDef;}}}}foreach($this->definitions
as$name=>$def){if(!$def->factory){if(!$def->class){throw
new
ServiceCreationException("Class and factory are missing in service '$name' definition.");}$def->factory=new
Statement($def->class);}}foreach($this->definitions
as$name=>$def){$factory=$def->factory->entity=$this->normalizeEntity($def->factory->entity);if(is_string($factory)&&preg_match('#^[\w\\\\]+\z#',$factory)&&$factory!==self::THIS_SERVICE){if(!class_exists($factory)||!Reflection\ClassType::from($factory)->isInstantiable()){throw
new
ServiceCreationException("Class $factory used in service '$name' has not been found or is not instantiable.");}}}foreach($this->definitions
as$name=>$def){$this->resolveClass($name);if(!$def->class){continue;}elseif(!class_exists($def->class)&&!interface_exists($def->class)){throw
new
ServiceCreationException("Class or interface $def->class used in service '$name' has not been found.");}else{$def->class=Reflection\ClassType::from($def->class)->getName();}}$this->classes=array();foreach($this->definitions
as$name=>$def){$class=$def->implement?:$def->class;if($def->autowired&&$class){foreach(class_parents($class)+class_implements($class)+array($class)as$parent){$this->classes[strtolower($parent)][]=(string)$name;}}}foreach($this->classes
as$class=>$foo){$this->addDependency(Reflection\ClassType::from($class)->getFileName());}}private
function
resolveClass($name,$recursive=array()){if(isset($recursive[$name])){throw
new
ServiceCreationException('Circular reference detected for services: '.implode(', ',array_keys($recursive)).'.');}$recursive[$name]=TRUE;$def=$this->definitions[$name];$factory=$def->factory->entity;if($def->class){return$def->class;}elseif(is_array($factory)){if($service=$this->getServiceName($factory[0])){if(Strings::contains($service,'\\')){$factory[0]=$service;}else{$factory[0]=$this->resolveClass($service,$recursive);if(!$factory[0]){return;}if($this->definitions[$service]->implement&&$factory[1]==='create'){return$def->class=$factory[0];}}}if(!is_callable($factory)){throw
new
ServiceCreationException("Factory '".Nette\Utils\Callback::toString($factory)."' is not callable.");}try{$reflection=Nette\Utils\Callback::toReflection($factory);}catch(\ReflectionException$e){throw
new
ServiceCreationException("Missing factory '".Nette\Utils\Callback::toString($factory)."'.");}$def->class=preg_replace('#[|\s].*#','',$reflection->getAnnotation('return'));if($def->class&&!class_exists($def->class)&&$def->class[0]!=='\\'&&$reflection
instanceof\ReflectionMethod){$def->class=$reflection->getDeclaringClass()->getNamespaceName().'\\'.$def->class;}}elseif($service=$this->getServiceName($factory)){if(!$def->implement){$def->autowired=FALSE;}if(Strings::contains($service,'\\')){return$def->class=$service;}if($this->definitions[$service]->implement){$def->autowired=FALSE;}return$def->class=$this->definitions[$service]->implement?:$this->resolveClass($service,$recursive);}else{return$def->class=$factory;}}function
addDependency($file){$this->dependencies[$file]=TRUE;return$this;}function
getDependencies(){unset($this->dependencies[FALSE]);return
array_keys($this->dependencies);}function
generateClasses(){unset($this->definitions[self::THIS_CONTAINER]);$this->addDefinition(self::THIS_CONTAINER)->setClass('Nette\DI\Container');$this->generatedClasses=array();$this->prepareClassList();$containerClass=$this->generatedClasses[]=new
Nette\PhpGenerator\ClassType('Container');$containerClass->addExtend('Nette\DI\Container');$containerClass->addMethod('__construct')->addBody('parent::__construct(?);',array($this->parameters));$definitions=$this->definitions;ksort($definitions);$meta=$containerClass->addProperty('meta',array())->setVisibility('protected')->setValue(array(Container::TYPES=>$this->classes));foreach($definitions
as$name=>$def){if($def->shared){foreach($def->tags
as$tag=>$value){$meta->value[Container::TAGS][$tag][$name]=$value;}}}foreach($definitions
as$name=>$def){try{$name=(string)$name;$methodName=Container::getMethodName($name);if(!PhpHelpers::isIdentifier($methodName)){throw
new
ServiceCreationException('Name contains invalid characters.');}$method=$containerClass->addMethod($methodName)->addDocument("@return ".($def->implement?:$def->class))->setBody($name===self::THIS_CONTAINER?'return $this;':$this->generateService($name))->setParameters($def->implement?array():$this->convertParameters($def->parameters));}catch(\Exception$e){throw
new
ServiceCreationException("Service '$name': ".$e->getMessage(),NULL,$e);}}return$this->generatedClasses;}private
function
generateService($name){$this->current=NULL;$def=$this->definitions[$name];$code='$service = '.$this->formatStatement($def->factory).";\n";$this->current=$name;if($def->class&&$def->class!==$def->factory->entity&&!$this->getServiceName($def->factory->entity)){$code.=PhpHelpers::formatArgs("if (!\$service instanceof $def->class) {\n"."\tthrow new Nette\\UnexpectedValueException(?);\n}\n",array("Unable to create service '$name', value returned by factory is not $def->class type."));}$setups=(array)$def->setup;if($def->inject&&$def->class){$injects=array();foreach(Helpers::getInjectProperties(Reflection\ClassType::from($def->class))as$property=>$type){$injects[]=new
Statement('$'.$property,array('@\\'.ltrim($type,'\\')));}foreach(get_class_methods($def->class)as$method){if(substr($method,0,6)==='inject'){$injects[]=new
Statement($method);}}foreach($injects
as$inject){foreach($setups
as$key=>$setup){if($setup->entity===$inject->entity){$inject=$setup;unset($setups[$key]);}}array_unshift($setups,$inject);}}foreach($setups
as$setup){if(is_string($setup->entity)&&strpbrk($setup->entity,':@?')===FALSE){$setup->entity=array('@self',$setup->entity);}$code.=$this->formatStatement($setup).";\n";}$code.='return $service;';if(!$def->implement){return$code;}$factoryClass=$this->generatedClasses[]=new
Nette\PhpGenerator\ClassType;$factoryClass->setName(str_replace(array('\\','.'),'_',"{$def->implement}Impl_{$name}"))->addImplement($def->implement)->setFinal(TRUE);$factoryClass->addProperty('container')->setVisibility('private');$factoryClass->addMethod('__construct')->addBody('$this->container = $container;')->addParameter('container')->setTypeHint('Nette\DI\Container');$factoryClass->addMethod(Reflection\ClassType::from($def->implement)->hasMethod('get')?'get':'create')->setParameters($this->convertParameters($def->parameters))->setBody(str_replace('$this','$this->container',$code));return"return new {$factoryClass->name}(\$this);";}private
function
convertParameters(array$parameters){$res=array();foreach($parameters
as$k=>$v){$tmp=explode(' ',is_int($k)?$v:$k);$param=$res[]=new
Nette\PhpGenerator\Parameter;$param->setName(end($tmp));if(!is_int($k)){$param=$param->setOptional(TRUE)->setDefaultValue($v);}if(isset($tmp[1])){$param->setTypeHint($tmp[0]);}}return$res;}function
formatStatement(Statement$statement){$entity=$this->normalizeEntity($statement->entity);$arguments=$statement->arguments;if(is_string($entity)&&Strings::contains($entity,'?')){return$this->formatPhp($entity,$arguments);}elseif($service=$this->getServiceName($entity)){if($this->definitions[$service]->shared){if($arguments){throw
new
ServiceCreationException("Unable to call service '$entity'.");}return$this->formatPhp('$this->getService(?)',array($service));}$params=array();foreach($this->definitions[$service]->parameters
as$k=>$v){$params[]=preg_replace('#\w+\z#','\$$0',(is_int($k)?$v:$k)).(is_int($k)?'':' = '.PhpHelpers::dump($v));}$rm=new
Reflection\GlobalFunction(create_function(implode(', ',$params),''));$arguments=Helpers::autowireArguments($rm,$arguments,$this);return$this->formatPhp('$this->?(?*)',array(Container::getMethodName($service),$arguments));}elseif($entity==='not'){return$this->formatPhp('!?',array($arguments[0]));}elseif(is_string($entity)){if($constructor=Reflection\ClassType::from($entity)->getConstructor()){$this->addDependency($constructor->getFileName());$arguments=Helpers::autowireArguments($constructor,$arguments,$this);}elseif($arguments){throw
new
ServiceCreationException("Unable to pass arguments, class $entity has no constructor.");}return$this->formatPhp("new $entity".($arguments?'(?*)':''),array($arguments));}elseif(!Nette\Utils\Arrays::isList($entity)||count($entity)!==2){throw
new
ServiceCreationException("Expected class, method or property, ".PhpHelpers::dump($entity)." given.");}elseif($entity[0]===''){return$this->formatPhp("$entity[1](?*)",array($arguments));}elseif(Strings::contains($entity[1],'$')){Validators::assert($arguments,'list:1',"setup arguments for '".Nette\Utils\Callback::toString($entity)."'");if($this->getServiceName($entity[0])){return$this->formatPhp('?->? = ?',array($entity[0],substr($entity[1],1),$arguments[0]));}else{return$this->formatPhp($entity[0].'::$? = ?',array(substr($entity[1],1),$arguments[0]));}}elseif($service=$this->getServiceName($entity[0])){$class=$this->definitions[$service]->implement;if(!$class||!method_exists($class,$entity[1])){$class=$this->definitions[$service]->class;}if($class){$arguments=$this->autowireArguments($class,$entity[1],$arguments);}return$this->formatPhp('?->?(?*)',array($entity[0],$entity[1],$arguments));}else{$arguments=$this->autowireArguments($entity[0],$entity[1],$arguments);return$this->formatPhp("$entity[0]::$entity[1](?*)",array($arguments));}}function
formatPhp($statement,$args){$that=$this;array_walk_recursive($args,function(&$val)use($that){list($val)=$that->normalizeEntity(array($val));if($val
instanceof
Statement){$val=ContainerBuilder::literal($that->formatStatement($val));}elseif($val==='@'.ContainerBuilder::THIS_CONTAINER){$val=ContainerBuilder::literal('$this');}elseif($service=$that->getServiceName($val)){$val=$service===$that->current?'$service':$that->formatStatement(new
Statement($val));$val=ContainerBuilder::literal($val);}elseif(is_string($val)&&preg_match('#^[\w\\\\]*::[A-Z][A-Z0-9_]*\z#',$val,$m)){$val=ContainerBuilder::literal(ltrim($val,':'));}});return
PhpHelpers::formatArgs($statement,$args);}function
expand($value){return
Helpers::expand($value,$this->parameters);}static
function
literal($phpCode){return
new
Nette\PhpGenerator\PhpLiteral($phpCode);}function
normalizeEntity($entity){if(is_string($entity)&&Strings::contains($entity,'::')&&!Strings::contains($entity,'?')){$entity=explode('::',$entity);}if(is_array($entity)&&$entity[0]instanceof
ServiceDefinition){$tmp=array_keys($this->definitions,$entity[0],TRUE);$entity[0]="@$tmp[0]";}elseif($entity
instanceof
ServiceDefinition){$tmp=array_keys($this->definitions,$entity,TRUE);$entity="@$tmp[0]";}elseif(is_array($entity)&&$entity[0]===$this){$entity[0]='@'.ContainerBuilder::THIS_CONTAINER;}return$entity;}function
getServiceName($arg){if(!is_string($arg)||!preg_match('#^@[\w\\\\.].*\z#',$arg)){return
FALSE;}$service=substr($arg,1);if($service===self::THIS_SERVICE){$service=$this->current;}if(Strings::contains($service,'\\')){if($this->classes===FALSE){return$service;}$res=$this->getByType($service);if(!$res){throw
new
ServiceCreationException("Reference to missing service of type $service.");}return$res;}if(!isset($this->definitions[$service])){throw
new
ServiceCreationException("Reference to missing service '$service'.");}return$service;}function
generateClass(){throw
new
Nette\DeprecatedException(__METHOD__.'() is deprecated; use generateClasses()[0] instead.');}}}namespace Nette\DI\Diagnostics{use
Nette;use
Nette\DI\Container;use
Nette\Diagnostics\Dumper;class
ContainerPanel
extends
Nette\Object
implements
Nette\Diagnostics\IBarPanel{private$container;function
__construct(Container$container){$this->container=$container;}function
getTab(){ob_start();?>
<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAQAAAC1+jfqAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAGSSURBVCjPVVFNSwJhEF78Ad79Cf6PvXQRsotUlzKICosuRYmR2RJR0KE6lBFFZVEbpFBSqKu2rum6llFS9HHI4iUhT153n6ZtIWMOM+/MM88z7wwH7s9Ub16SJcnbmrNcxVm2q7Z8/QPvEOtntpj92NkCqITLepEpjix7xQtiLOoQ2b6+E7YAN/5nfOEJ2WbKqOIOJ4bYVMEQx4LfBBQDsvFMhUcCVU1/CxVXmDBGA5ZETrhDCQVcYAPbyEJBhvrnBVPiSpNr6cYDNCQwo4zzU/ySckkgDYuNuVpI42T9k4gLKGMPs/xPzzovQiY2hQYe0jlJfyNNhTqiWDYBq/wBMcSRpnyPzu1oS7WtxjVBSthU1vgVksiQ3Dn6Gp5ah2YOKQo5GiuHPA6xT1EKpxQNCNYejgIR457KKio0S56YckjSa9jo//3mrj+BV0QQagqGTOo+Y7gZIf1puP3WHoLhEb2PjTlCTCWGXtbp8DCX3hZuOdaIc9A+aQvWk4ihq95p67a7nP+u+Ws+r0dql9z/zv0NCYhdCPKZ7oYAAAAASUVORK5CYII="
/>&nbsp;
<?php
return
ob_get_clean();}function
getPanel(){$services=$factories=array();foreach(Nette\Reflection\ClassType::from($this->container)->getMethods()as$method){if(preg_match('#^create(Service)?_*(.+)\z#',$method->getName(),$m)){if($m[1]){$services[str_replace('__','.',strtolower(substr($m[2],0,1)).substr($m[2],1))]=$method->getAnnotation('return');}elseif($method->isPublic()){$factories['create'.$m[2]]=$method->getAnnotation('return');}}}ksort($services);ksort($factories);$container=$this->container;$registry=$this->getContainerProperty('registry');$tags=array();$meta=$this->getContainerProperty('meta');if(isset($meta[Container::TAGS])){foreach($meta[Container::TAGS]as$tag=>$tmp){foreach($tmp
as$service=>$val){$tags[$service][$tag]=$val;}}}ob_start();?>
<style class="nette-debug">#nette-debug .nette-ContainerPanel .nette-inner{width:700px}#nette-debug .nette-ContainerPanel table{width:100%;white-space:nowrap}#nette-debug .nette-ContainerPanel .created{font-weight:bold}#nette-debug .nette-ContainerPanel .yes{color:green;font-weight:bold}</style>

<div class="nette-ContainerPanel">
<h1><?php echo
get_class($this->container)?></h1>

<div class="nette-inner">
	<h2>Parameters</h2>

	<div class="nette-ContainerPanel-parameters">
		<?php echo
Dumper::toHtml($this->container->parameters);?>
	</div>

	<h2>Services</h2>

	<table>
		<thead>
		<tr>
			<th>Name</th>
			<th>Autowired</th>
			<th>Service</th>
			<th>Tags</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($services
as$name=>$class):?>
		<?php $autowired=in_array($name,$container->findByType($class));?>
		<tr>
			<td class="<?php echo
isset($registry[$name])?'created':''?>"><?php echo
htmlSpecialChars($name)?></td>
			<td class="<?php echo$autowired?'yes':''?>"><?php echo$autowired?'yes':'no'?></td>
			<td>
				<?php if(isset($registry[$name])&&!$registry[$name]instanceof
Nette\DI\Container):?>
					<?php echo
Dumper::toHtml($registry[$name],array(Dumper::COLLAPSE=>TRUE));?>
				<?php elseif(isset($registry[$name])):?>
					<code><?php echo
get_class($registry[$name])?></code>
				<?php elseif(is_string($class)):?>
					<code><?php echo
htmlSpecialChars($class)?></code>
				<?php endif?>
			</td>
			<td><?php if(isset($tags[$name])){echo
Dumper::toHtml($tags[$name],array(Dumper::COLLAPSE=>TRUE));}?></td>
		</tr>
		<?php endforeach?>
		</tbody>
	</table>

	<h2>Factories</h2>

	<table>
		<thead>
		<tr>
			<th>Method</th>
			<th>Returns</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($factories
as$name=>$class):?>
		<tr>
			<td><?php echo
htmlSpecialChars($name)?>()</td>
			<td><code><?php echo
htmlSpecialChars($class)?><code></td>
		</tr>
		<?php endforeach?>
		</tbody>
	</table>
</div>
</div>
<?php
return
ob_get_clean();}private
function
getContainerProperty($name){$prop=Nette\Reflection\ClassType::from('Nette\DI\Container')->getProperty($name);$prop->setAccessible(TRUE);return$prop->getValue($this->container);}}}namespace Nette\DI{use
Nette;class
MissingServiceException
extends
Nette\InvalidStateException{}class
ServiceCreationException
extends
Nette\InvalidStateException{}}namespace Nette\DI\Extensions{use
Nette;use
Nette\DI\ContainerBuilder;class
ConstantsExtension
extends
Nette\DI\CompilerExtension{function
afterCompile(Nette\PhpGenerator\ClassType$class){foreach($this->getConfig()as$name=>$value){$class->methods['initialize']->addBody('define(?, ?);',array($name,$value));}}}class
ExtensionsExtension
extends
Nette\DI\CompilerExtension{function
loadConfiguration(){foreach($this->getConfig()as$name=>$class){$this->compiler->addExtension($name,new$class);}}}class
NetteAccessor
extends
Nette\Object{private$container;function
__construct(Nette\DI\Container$container){$this->container=$container;}function
__call($name,$args){if(substr($name,0,6)==='create'){$method=$this->container->getMethodName('nette.'.substr($name,6));trigger_error("Factory accessing via nette->$name() is deprecated, use $method().",E_USER_DEPRECATED);return
call_user_func_array(array($this->container,$method),$args);}throw
new
Nette\NotSupportedException;}function&__get($name){trigger_error("Service accessing via nette->$name is deprecated, use 'nette.$name'.",E_USER_DEPRECATED);$service=$this->container->getService("nette.$name");return$service;}}use
Nette\Utils\Validators;class
NetteExtension
extends
Nette\DI\CompilerExtension{public$defaults=array('http'=>array('proxy'=>array()),'session'=>array('debugger'=>FALSE,'autoStart'=>'smart','expiration'=>NULL),'application'=>array('debugger'=>TRUE,'errorPresenter'=>'Nette:Error','catchExceptions'=>NULL,'mapping'=>NULL),'routing'=>array('debugger'=>TRUE,'routes'=>array()),'security'=>array('debugger'=>TRUE,'frames'=>'SAMEORIGIN','users'=>array(),'roles'=>array(),'resources'=>array()),'mailer'=>array('smtp'=>FALSE),'database'=>array(),'forms'=>array('messages'=>array()),'latte'=>array('xhtml'=>FALSE,'macros'=>array()),'container'=>array('debugger'=>FALSE,'accessors'=>TRUE),'debugger'=>array('email'=>NULL,'editor'=>NULL,'browser'=>NULL,'strictMode'=>NULL,'bar'=>array(),'blueScreen'=>array()));public$databaseDefaults=array('dsn'=>NULL,'user'=>NULL,'password'=>NULL,'options'=>NULL,'debugger'=>TRUE,'explain'=>TRUE,'reflection'=>'Nette\Database\Reflection\DiscoveredReflection');function
loadConfiguration(){$container=$this->getContainerBuilder();$config=$this->getConfig($this->defaults);$config['application']['catchExceptions']=!$container->parameters['debugMode'];if(isset($config['xhtml'])){$config['latte']['xhtml']=$config['xhtml'];}$container->addDefinition('nette')->setClass('Nette\DI\Extensions\NetteAccessor',array('@container'));$this->setupCache($container);$this->setupHttp($container,$config['http']);$this->setupSession($container,$config['session']);$this->setupSecurity($container,$config['security']);$this->setupApplication($container,$config['application']);$this->setupRouting($container,$config['routing']);$this->setupMailer($container,$config['mailer']);$this->setupForms($container);$this->setupTemplating($container,$config['latte']);$this->setupDatabase($container,$config['database']);$this->setupContainer($container,$config['container']);}private
function
setupCache(ContainerBuilder$container){$container->addDefinition($this->prefix('cacheJournal'))->setClass('Nette\Caching\Storages\FileJournal',array($container->expand('%tempDir%')));$container->addDefinition('cacheStorage')->setClass('Nette\Caching\Storages\FileStorage',array($container->expand('%tempDir%/cache')));$container->addDefinition($this->prefix('templateCacheStorage'))->setClass('Nette\Caching\Storages\PhpFileStorage',array($container->expand('%tempDir%/cache')))->setAutowired(FALSE);$container->addDefinition($this->prefix('cache'))->setClass('Nette\Caching\Cache',array(1=>$container::literal('$namespace')))->setParameters(array('namespace'=>NULL));}private
function
setupHttp(ContainerBuilder$container,array$config){$container->addDefinition($this->prefix('httpRequestFactory'))->setClass('Nette\Http\RequestFactory')->addSetup('setProxy',array($config['proxy']));$container->addDefinition('httpRequest')->setClass('Nette\Http\Request')->setFactory('@Nette\Http\RequestFactory::createHttpRequest');$container->addDefinition('httpResponse')->setClass('Nette\Http\Response');$container->addDefinition($this->prefix('httpContext'))->setClass('Nette\Http\Context');}private
function
setupSession(ContainerBuilder$container,array$config){$session=$container->addDefinition('session')->setClass('Nette\Http\Session');if(isset($config['expiration'])){$session->addSetup('setExpiration',array($config['expiration']));}if($container->parameters['debugMode']&&$config['debugger']){$session->addSetup('Nette\Diagnostics\Debugger::getBar()->addPanel(?)',array(new
Nette\DI\Statement('Nette\Http\Diagnostics\SessionPanel')));}unset($config['expiration'],$config['autoStart'],$config['debugger']);if(!empty($config)){$session->addSetup('setOptions',array($config));}}private
function
setupSecurity(ContainerBuilder$container,array$config){$container->addDefinition($this->prefix('userStorage'))->setClass('Nette\Http\UserStorage');$user=$container->addDefinition('user')->setClass('Nette\Security\User');if($container->parameters['debugMode']&&$config['debugger']){$user->addSetup('Nette\Diagnostics\Debugger::getBar()->addPanel(?)',array(new
Nette\DI\Statement('Nette\Security\Diagnostics\UserPanel')));}if($config['users']){$container->addDefinition($this->prefix('authenticator'))->setClass('Nette\Security\SimpleAuthenticator',array($config['users']));}if($config['roles']||$config['resources']){$authorizator=$container->addDefinition($this->prefix('authorizator'))->setClass('Nette\Security\Permission');foreach($config['roles']as$role=>$parents){$authorizator->addSetup('addRole',array($role,$parents));}foreach($config['resources']as$resource=>$parents){$authorizator->addSetup('addResource',array($resource,$parents));}}}private
function
setupApplication(ContainerBuilder$container,array$config){$application=$container->addDefinition('application')->setClass('Nette\Application\Application')->addSetup('$catchExceptions',$config['catchExceptions'])->addSetup('$errorPresenter',$config['errorPresenter'])->addSetup('!headers_sent() && header(?);','X-Powered-By: Nette Framework');if($config['debugger']){$application->addSetup('Nette\Application\Diagnostics\RoutingPanel::initializePanel');}$presenterFactory=$container->addDefinition($this->prefix('presenterFactory'))->setClass('Nette\Application\PresenterFactory',array(isset($container->parameters['appDir'])?$container->parameters['appDir']:NULL));if($config['mapping']){$presenterFactory->addSetup('setMapping',array($config['mapping']));}}private
function
setupRouting(ContainerBuilder$container,array$config){$router=$container->addDefinition('router')->setClass('Nette\Application\Routers\RouteList');foreach($config['routes']as$mask=>$action){$router->addSetup('$service[] = new Nette\Application\Routers\Route(?, ?);',array($mask,$action));}if($container->parameters['debugMode']&&$config['debugger']){$container->getDefinition('application')->addSetup('Nette\Diagnostics\Debugger::getBar()->addPanel(?)',array(new
Nette\DI\Statement('Nette\Application\Diagnostics\RoutingPanel')));}}private
function
setupMailer(ContainerBuilder$container,array$config){if(empty($config['smtp'])){$container->addDefinition($this->prefix('mailer'))->setClass('Nette\Mail\SendmailMailer');}else{$container->addDefinition($this->prefix('mailer'))->setClass('Nette\Mail\SmtpMailer',array($config));}$container->addDefinition($this->prefix('mail'))->setClass('Nette\Mail\Message')->addSetup('setMailer')->setShared(FALSE);}private
function
setupForms(ContainerBuilder$container){$container->addDefinition($this->prefix('basicForm'))->setClass('Nette\Forms\Form')->setShared(FALSE);}private
function
setupTemplating(ContainerBuilder$container,array$config){$latte=$container->addDefinition($this->prefix('latte'))->setClass('Nette\Latte\Engine')->setShared(FALSE);if($config['xhtml']){$latte->addSetup('$service->getCompiler()->defaultContentType = ?',Nette\Latte\Compiler::CONTENT_XHTML);}$container->addDefinition($this->prefix('template'))->setClass('Nette\Templating\FileTemplate')->addSetup('registerFilter',array($latte))->addSetup('registerHelperLoader',array('Nette\Templating\Helpers::loader'))->setShared(FALSE);foreach($config['macros']as$macro){if(strpos($macro,'::')===FALSE&&class_exists($macro)){$macro.='::install';}else{Validators::assert($macro,'callable');}$latte->addSetup($macro.'(?->compiler)',array('@self'));}}private
function
setupDatabase(ContainerBuilder$container,array$config){if(isset($config['dsn'])){$config=array('default'=>$config);}$autowired=TRUE;foreach((array)$config
as$name=>$info){if(!is_array($info)){continue;}$info+=$this->databaseDefaults+array('autowired'=>$autowired);$autowired=FALSE;foreach((array)$info['options']as$key=>$value){if(preg_match('#^PDO::\w+\z#',$key)){unset($info['options'][$key]);$info['options'][constant($key)]=$value;}}if(!$info['reflection']){$reflection=NULL;}elseif(is_string($info['reflection'])){$reflection=new
Nette\DI\Statement(preg_match('#^[a-z]+\z#',$info['reflection'])?'Nette\Database\Reflection\\'.ucfirst($info['reflection']).'Reflection':$info['reflection'],strtolower($info['reflection'])==='discovered'?array('@self'):array());}else{$tmp=Nette\DI\Compiler::filterArguments(array($info['reflection']));$reflection=reset($tmp);}$connection=$container->addDefinition($this->prefix("database.$name"))->setClass('Nette\Database\Connection',array($info['dsn'],$info['user'],$info['password'],$info['options']))->setAutowired($info['autowired'])->addSetup('setSelectionFactory',array(new
Nette\DI\Statement('Nette\Database\SelectionFactory',array('@self',$reflection))))->addSetup('Nette\Diagnostics\Debugger::getBlueScreen()->addPanel(?)',array('Nette\Database\Diagnostics\ConnectionPanel::renderException'));$selectionFactory=$container->addDefinition($this->prefix("database.$name.selectionFactory"))->setClass('Nette\Database\SelectionFactory')->setFactory(array($connection,'getSelectionFactory'))->setAutowired($info['autowired']);if($container->parameters['debugMode']&&$info['debugger']){$connection->addSetup('Nette\Database\Helpers::createDebugPanel',array($connection,!empty($info['explain']),$name));}}}private
function
setupContainer(ContainerBuilder$container,array$config){if($config['accessors']){$container->parameters['container']['accessors']=TRUE;}}function
afterCompile(Nette\PhpGenerator\ClassType$class){$initialize=$class->methods['initialize'];$container=$this->getContainerBuilder();$config=$this->getConfig($this->defaults);foreach(array('email','editor','browser','strictMode','maxLen','maxDepth','showLocation','scream')as$key){if(isset($config['debugger'][$key])){$initialize->addBody('Nette\Diagnostics\Debugger::$? = ?;',array($key,$config['debugger'][$key]));}}if($container->parameters['debugMode']){if($config['container']['debugger']){$config['debugger']['bar'][]='Nette\DI\Diagnostics\ContainerPanel';}foreach((array)$config['debugger']['bar']as$item){$initialize->addBody($container->formatPhp('Nette\Diagnostics\Debugger::getBar()->addPanel(?);',Nette\DI\Compiler::filterArguments(array(is_string($item)?new
Nette\DI\Statement($item):$item))));}foreach((array)$config['debugger']['blueScreen']as$item){$initialize->addBody($container->formatPhp('Nette\Diagnostics\Debugger::getBlueScreen()->addPanel(?);',Nette\DI\Compiler::filterArguments(array($item))));}}if(!empty($container->parameters['tempDir'])){$initialize->addBody('Nette\Caching\Storages\FileStorage::$useDirectories = ?;',array($this->checkTempDir($container->expand('%tempDir%/cache'))));}foreach((array)$config['forms']['messages']as$name=>$text){$initialize->addBody('Nette\Forms\Rules::$defaultMessages[Nette\Forms\Form::?] = ?;',array($name,$text));}if($config['session']['autoStart']==='smart'){$initialize->addBody('$this->getService("session")->exists() && $this->getService("session")->start();');}elseif($config['session']['autoStart']){$initialize->addBody('$this->getService("session")->start();');}if($config['latte']['xhtml']){$initialize->addBody('Nette\Utils\Html::$xhtml = ?;',array(TRUE));}if(isset($config['security']['frames'])&&$config['security']['frames']!==TRUE){$frames=$config['security']['frames'];if($frames===FALSE){$frames='DENY';}elseif(preg_match('#^https?:#',$frames)){$frames="ALLOW-FROM $frames";}$initialize->addBody('header(?);',array("X-Frame-Options: $frames"));}foreach($container->findByTag('run')as$name=>$on){if($on){$initialize->addBody('$this->getService(?);',array($name));}}if(!empty($config['container']['accessors'])){$definitions=$container->definitions;ksort($definitions);foreach($definitions
as$name=>$def){if($def->shared&&Nette\PhpGenerator\Helpers::isIdentifier($name)){$type=$def->implement?:$def->class;$class->addDocument("@property $type \$$name");}}}}private
function
checkTempDir($dir){$uniq=uniqid('_',TRUE);if(!@mkdir("$dir/$uniq")){throw
new
Nette\InvalidStateException("Unable to write to directory '$dir'. Make this directory writable.");}$isWritable=@file_put_contents("$dir/$uniq/_",'')!==FALSE;if($isWritable){unlink("$dir/$uniq/_");}rmdir("$dir/$uniq");return$isWritable;}}class
PhpExtension
extends
Nette\DI\CompilerExtension{function
afterCompile(Nette\PhpGenerator\ClassType$class){$initialize=$class->methods['initialize'];foreach($this->getConfig()as$name=>$value){if(!is_scalar($value)){throw
new
Nette\InvalidStateException("Configuration value for directive '$name' is not scalar.");}elseif($name==='include_path'){$initialize->addBody('set_include_path(?);',array(str_replace(';',PATH_SEPARATOR,$value)));}elseif($name==='ignore_user_abort'){$initialize->addBody('ignore_user_abort(?);',array($value));}elseif($name==='max_execution_time'){$initialize->addBody('set_time_limit(?);',array($value));}elseif($name==='date.timezone'){$initialize->addBody('date_default_timezone_set(?);',array($value));}elseif(function_exists('ini_set')){$initialize->addBody('ini_set(?, ?);',array($name,$value));}elseif(ini_get($name)!=$value){throw
new
Nette\NotSupportedException('Required function ini_set() is disabled.');}}}}}namespace Nette\DI{use
Nette;final
class
Helpers{static
function
expand($var,array$params,$recursive=FALSE){if(is_array($var)){$res=array();foreach($var
as$key=>$val){$res[$key]=self::expand($val,$params,$recursive);}return$res;}elseif($var
instanceof\stdClass||$var
instanceof
Statement){$res=clone$var;foreach($var
as$key=>$val){$res->$key=self::expand($val,$params,$recursive);}return$res;}elseif(!is_string($var)){return$var;}$parts=preg_split('#%([\w.-]*)%#i',$var,-1,PREG_SPLIT_DELIM_CAPTURE);$res='';foreach($parts
as$n=>$part){if($n
%
2===0){$res.=$part;}elseif($part===''){$res.='%';}elseif(isset($recursive[$part])){throw
new
Nette\InvalidArgumentException('Circular reference detected for variables: '.implode(', ',array_keys($recursive)).'.');}else{$val=Nette\Utils\Arrays::get($params,explode('.',$part));if($recursive){$val=self::expand($val,$params,(is_array($recursive)?$recursive:array())+array($part=>1));}if(strlen($part)+2===strlen($var)){return$val;}if(!is_scalar($val)){throw
new
Nette\InvalidArgumentException("Unable to concatenate non-scalar parameter '$part' into '$var'.");}$res.=$val;}}return$res;}static
function
autowireArguments(\ReflectionFunctionAbstract$method,array$arguments,$container){$optCount=0;$num=-1;$res=array();foreach($method->getParameters()as$num=>$parameter){if(array_key_exists($num,$arguments)){$res[$num]=$arguments[$num];unset($arguments[$num]);$optCount=0;}elseif(array_key_exists($parameter->getName(),$arguments)){$res[$num]=$arguments[$parameter->getName()];unset($arguments[$parameter->getName()]);$optCount=0;}elseif($class=$parameter->getClassName()){$res[$num]=$container->getByType($class,FALSE);if($res[$num]===NULL){if($parameter->allowsNull()){$optCount++;}else{throw
new
ServiceCreationException("No service of type {$class} found. Make sure the type hint in $method is written correctly and service of this type is registered.");}}else{if($container
instanceof
ContainerBuilder){$res[$num]='@'.$res[$num];}$optCount=0;}}elseif($parameter->isOptional()){$res[$num]=$parameter->isDefaultValueAvailable()?$parameter->getDefaultValue():NULL;$optCount++;}else{throw
new
ServiceCreationException("Parameter $parameter has no type hint, so its value must be specified.");}}while(array_key_exists(++$num,$arguments)){$res[$num]=$arguments[$num];unset($arguments[$num]);$optCount=0;}if($arguments){throw
new
ServiceCreationException("Unable to pass specified arguments to $method.");}return$optCount?array_slice($res,0,-$optCount):$res;}static
function
getInjectProperties(Nette\Reflection\ClassType$class){$res=array();foreach($class->getProperties(\ReflectionProperty::IS_PUBLIC)as$property){$type=$property->getAnnotation('var');if(!$property->getAnnotation('inject')){continue;}elseif(!$type){throw
new
Nette\InvalidStateException("Property $property has not @var annotation.");}elseif(!class_exists($type)&&!interface_exists($type)){if($type[0]!=='\\'){$type=$property->getDeclaringClass()->getNamespaceName().'\\'.$type;}if(!class_exists($type)&&!interface_exists($type)){throw
new
Nette\InvalidStateException("Please use a fully qualified name of class/interface in @var annotation at $property property. Class '$type' cannot be found.");}}$res[$property->getName()]=$type;}return$res;}}class
ServiceDefinition
extends
Nette\Object{public$class;public$factory;public$setup=array();public$parameters=array();public$tags=array();public$autowired=TRUE;public$shared=TRUE;public$inject=TRUE;public$implement;function
setClass($class,array$args=array()){$this->class=$class;if($args){$this->setFactory($class,$args);}return$this;}function
setFactory($factory,array$args=array()){$this->factory=new
Statement($factory,$args);return$this;}function
setArguments(array$args=array()){if($this->factory){$this->factory->arguments=$args;}else{$this->setClass($this->class,$args);}return$this;}function
addSetup($target,$args=NULL){$this->setup[]=new
Statement($target,is_array($args)?$args:array_slice(func_get_args(),1));return$this;}function
setParameters(array$params){$this->shared=$this->autowired=FALSE;$this->parameters=$params;return$this;}function
addTag($tag,$attrs=TRUE){$this->tags[$tag]=$attrs;return$this;}function
setAutowired($on){$this->autowired=$on;return$this;}function
setShared($on){$this->shared=(bool)$on;$this->autowired=$this->shared?$this->autowired:FALSE;return$this;}function
setInject($on){$this->inject=(bool)$on;return$this;}function
setImplement($implement){$this->implement=$implement;$this->shared=TRUE;return$this;}}class
Statement
extends
Nette\Object{public$entity;public$arguments;function
__construct($entity,array$arguments=array()){$this->entity=$entity;$this->arguments=$arguments;}}}namespace Nette\Diagnostics{use
Nette;class
Bar
extends
Nette\Object{private$panels=array();function
addPanel(IBarPanel$panel,$id=NULL){if($id===NULL){$c=0;do{$id=get_class($panel).($c++?"-$c":'');}while(isset($this->panels[$id]));}$this->panels[$id]=$panel;return$this;}function
getPanel($id){return
isset($this->panels[$id])?$this->panels[$id]:NULL;}function
render(){$obLevel=ob_get_level();$panels=array();foreach($this->panels
as$id=>$panel){try{$panels[]=array('id'=>preg_replace('#[^a-z0-9]+#i','-',$id),'tab'=>$tab=(string)$panel->getTab(),'panel'=>$tab?(string)$panel->getPanel():NULL);}catch(\Exception$e){$panels[]=array('id'=>"error-".preg_replace('#[^a-z0-9]+#i','-',$id),'tab'=>"Error in $id",'panel'=>'<h1>Error: '.$id.'</h1><div class="nette-inner">'.nl2br(htmlSpecialChars($e,ENT_IGNORE)).'</div>');while(ob_get_level()>$obLevel){ob_end_clean();}}}@session_start();$session=&$_SESSION['__NF']['debuggerbar'];if(preg_match('#^Location:#im',implode("\n",headers_list()))){$session[]=$panels;return;}foreach(array_reverse((array)$session)as$reqId=>$oldpanels){$panels[]=array('tab'=>'<span title="Previous request before redirect">previous</span>','panel'=>NULL,'previous'=>TRUE);foreach($oldpanels
as$panel){$panel['id'].='-'.$reqId;$panels[]=$panel;}}$session=NULL;?>




<!-- Nette Debug Bar -->

<?php ob_start()?>
&nbsp;

<style id="nette-debug-style" class="nette-debug">#nette-debug{display:none}body #nette-debug{position:absolute;bottom:0;right:0}#nette-debug *{font:inherit;color:inherit;background:transparent;margin:0;padding:0;border:none;text-align:inherit;list-style:inherit;opacity:1;border-radius:0;box-shadow:none}#nette-debug b,#nette-debug strong{font-weight:bold}#nette-debug i,#nette-debug em{font-style:italic}#nette-debug a{color:#125EAE;text-decoration:none}#nette-debug .nette-panel a{color:#125EAE;text-decoration:none}#nette-debug a:hover,#nette-debug a:active,#nette-debug a:focus{background-color:#125EAE;color:white}#nette-debug .nette-panel h2,#nette-debug .nette-panel h3,#nette-debug .nette-panel p{margin:.4em 0}#nette-debug .nette-panel table{border-collapse:collapse;background:#FDF5CE}#nette-debug .nette-panel tr:nth-child(2n) td{background:#F7F0CB}#nette-debug .nette-panel td,#nette-debug .nette-panel th{border:1px solid #E6DFBF;padding:2px 5px;vertical-align:top;text-align:left}#nette-debug .nette-panel th{background:#F4F3F1;color:#655E5E;font-size:90%;font-weight:bold}#nette-debug .nette-panel pre,#nette-debug .nette-panel code{font:9pt/1.5 Consolas,monospace}#nette-debug table .nette-right{text-align:right}#nette-debug-bar{font:normal normal 12px/21px Tahoma,sans-serif;color:#333;border:1px solid #c9c9c9;background:#EDEAE0 url('data:image/png;base64,R0lGODlhAQAVALMAAOTh1/Px6eHe1fHv5e/s4vLw6Ofk2u3q4PPw6PPx6PDt5PLw5+Dd1OXi2Ojm3Orn3iH5BAAAAAAALAAAAAABABUAAAQPMISEyhpYkfOcaQAgCEwEADs=') top;position:fixed;right:0;bottom:0;overflow:auto;min-height:21px;_float:left;min-width:50px;white-space:nowrap;z-index:30000;opacity:.9;border-radius:3px;box-shadow:1px 1px 10px rgba(0,0,0,.15)}#nette-debug-bar:hover{opacity:1}#nette-debug-bar ul{list-style:none none;margin-left:4px;clear:left}#nette-debug-bar li{float:left}#nette-debug-bar ul.nette-previous li{font-size:90%;opacity:.6;background:#F5F3EE}#nette-debug-bar ul.nette-previous li:first-child{width:45px}#nette-debug-bar img{vertical-align:middle;position:relative;top:-1px;margin-right:3px}#nette-debug-bar li a{color:#000;display:block;padding:0 4px}#nette-debug-bar li a:hover{color:black;background:#c3c1b8}#nette-debug-bar li .nette-warning{color:#D32B2B;font-weight:bold}#nette-debug-bar li>span{padding:0 4px}#nette-debug-logo{background:url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAC0AAAAPCAYAAABwfkanAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAABiFJREFUSMe1VglPlGcQ5i+1xjZNqxREtGq8ahCPWsVGvEDBA1BBRQFBDjkE5BYUzwpovRBUREBEBbl3OVaWPfj2vi82eTrvbFHamLRJ4yYTvm+u95mZZ96PoKAv+LOatXBYZ+Bx6uFy6DGnt1m0EOKwSmQzwmHTgX5B/1W+yM9GYJ02CX6/B/5ZF+w2A4x6FYGTYDVp4PdY2Tbrs5N+mnRa2Km4/wV6rhPzQQj5fDc1mJM5nd0iYdZtQWtrCxobGnDpUiledTynbuvg99mgUMhw924Trl2rR01NNSTNJE9iDpTV8innv4K2kZPLroPXbYLHZeSu2K1aeF0muJ2GvwGzmNSwU2E+svm8ZrgdBliMaha/34Vx+RAKCgpwpa4OdbW1UE/L2cc/68WtWzdRVlaG6uoqtD1/BA/pA1MIxLvtes7pc5vhoDOE/rOgbVSdf9aJWa8dBp0Kyg+jdLiTx2vQKWEyqGmcNkqg4iTC1+dzQatWkK+cJqPD7KyFaKEjvRuNjY24fLkGdXW1ePjwAeX4QHonDNI0A75+/RpqqqshH+6F2UAUMaupYXouykV0mp6SQ60coxgL8Z4aMg/4x675/V60v3jKB+Xl5WJibIC4KPEIS0qKqWv5GOh7BZ/HSIk9kA33o7y8DOfPZ6GQOipkXDZAHXKxr4ipqqpkKS6+iIrycgz2dyMnJxtVlZUsotNZWZmor79KBbvgpdjm5sfIzc1hv4L8fKJPDTfJZZc+gRYKr8sAEy2DcBRdEEk62ltx9uwZ5qNILoDU1l6mbrvx5EkzUlKSuTiR7PHjR3x4fv4FyIbeIic7G5WVFUyN+qtX+Lnt2SPcvn2LfURjhF7kE4WPDr+Bx+NEUVEhkpNPoImm5CSOl5aUIC3tLOMR59gtAY4HidGIzj14cB8ZGRkM8kJeHk6cOI4xWR8vSl5uLlJTT6O74xnT5lB8PM6cSYXVqILb5UBWZiYSExMYkE4zzjqX00QHG+h9AjPqMei0k3ywy2khMdNiq6BVCf04T6ekuBgJCUdRUVHOBQwPvkNSUiLjaGi4Q/5qFgYtHgTXRJdTT59GenoaA5gY64deq0Bc3EGuNj4+DnppEheLijhZRkY6SktLsGPHdi6irOwSFTRAgO04deokTSIFsbExuHfvLnFSx8DevelAfFwcA0lJTqZi5PDS9aci/sbE7Oe4wsICbtD27b/ye1NTI3FeSX4W2gdFALRD3A4eM44ePcKViuD79/8gnZP5Kg4+cCAW2dnnqUM2Lujw4UM4ePAA2ztfPsHIYA/sdOt43A50d7UFCjkUj+joXVBMDJDeDhcVk08cjd61C3v37uFYp8PKXX3X8xJRUTtw7FgSn3Xzxg10d7ZCqRjkM+02C7pettDNogqAFjzxuI3YHR2Nffv2coXy0V44HGZERm7kJNu2/cK8bW9rwbp1axnMnj27uUijQQOb1QyTcYZ3YMOGn/Hbzp1crAAvaDfY38O5hW3//n0ce+TIYWiUcub1xo0R2Lp1y8cYsUMWM125VhPe93Zj7do1vEPi26GfUdBFbhK8tGHrli1YsWwpgoOD0dXRQqAtXMCy8DBs3rwJoSGLsWrVclylBdoUGYlVK1dg9eqVCFsSSs8/4btvvmUwEnE0KTERISE/IiIiAsGLF2HhwgU8qbc97QgPX8qFr1mzGgu+/opzdL5o5l1aEhqC9evXYWlYKFYsD6e/YVj0w/dMGZVyBDMqeaDTRuKpkxYjIz2dOyeup6H3r2kkOuJ1H3N5Z1QUzp3LQF9vJ4xGLQYHXiM9LY0pEhsTg+PHj9HNcJu4OcL3uaQZY86LiZw8mcJTkmhBTUYJbU8fcoygobgWR4Z6iKtTPLE7d35HYkICT1dIZuY59HQ9412StBPQTMvw8Z6WaMNFxy3Gab4TeQT0M9IHwUT/G0i0MGIJ9CTiJjBIH+iQaQbC7+QnfEXiQL6xgF09TjETHCt8RbeMuil+D8RNsV1LHdQoZfR/iJJzCZuYmEE/Bd3MJNs/+0UURgFWJJ//aQ8k+CsxVTqnVytHObkQrUoG8T4/bs4u4ubbxLPwFzYNPc8HI2zijLm84l39Dx8hfwJenFezFBKKQwAAAABJRU5ErkJggg==') 0 50% no-repeat;min-width:45px;cursor:move}#nette-debug-logo span{display:none}#nette-debug .nette-panel{font:normal normal 12px/1.5 sans-serif;background:white;color:#333;text-align:left}#nette-debug h1{font:normal normal 23px/1.4 Tahoma,sans-serif;color:#575753;margin:-5px -5px 5px;padding:0 25px 5px 5px}#nette-debug .nette-mode-peek .nette-inner,#nette-debug .nette-mode-float .nette-inner{max-width:700px;max-height:500px;overflow:auto}#nette-debug .nette-panel .nette-icons{display:none}#nette-debug .nette-mode-peek{display:none;position:fixed;right:0;bottom:0;padding:10px;min-width:150px;min-height:50px;border-radius:5px;box-shadow:1px 1px 20px rgba(102,102,102,0.36);border:1px solid rgba(0,0,0,0.1)}#nette-debug .nette-mode-peek h1{cursor:move}#nette-debug .nette-mode-float{position:fixed;right:0;bottom:0;padding:10px;min-width:150px;min-height:50px;border-radius:5px;opacity:.95;box-shadow:1px 1px 30px rgba(102,102,102,0.36);border:1px solid rgba(0,0,0,0.1)}#nette-debug .nette-focused{opacity:1}#nette-debug .nette-mode-float h1{cursor:move}#nette-debug .nette-mode-float .nette-icons{display:block;position:absolute;top:0;right:5px;font-size:18px}#nette-debug .nette-icons a{color:#575753}#nette-debug .nette-icons a:hover{color:white}#nette-debug pre.nette-dump div{padding-left:3ex}#nette-debug pre.nette-dump div div{border-left:1px solid rgba(0,0,0,.1);margin-left:.5ex}#nette-debug pre.nette-dump{background:#FDF5CE;padding:.4em .7em;border:1px dotted silver;overflow:auto}#nette-debug table pre.nette-dump{padding:0;margin:0;border:none}#nette-debug .nette-dump-array,#nette-debug .nette-dump-object{color:#C22}#nette-debug .nette-dump-string{color:#35D}#nette-debug .nette-dump-number{color:#090}#nette-debug .nette-dump-null,#nette-debug .nette-dump-bool{color:#850}#nette-debug .nette-dump-visibility{font-size:85%;color:#999}#nette-debug .nette-dump-indent{display:none}@media print{#nette-debug *{display:none}}.nette-collapsed{display:none}.nette-toggle,.nette-toggle-collapsed{cursor:pointer}.nette-toggle:after{content:" ▼";opacity:.4}.nette-toggle-collapsed:after{content:" ►";opacity:.4}pre.nette-dump{color:#444;background:white}pre.nette-dump div{padding-left:3ex}pre.nette-dump div div{border-left:1px solid rgba(0,0,0,.1);margin-left:.5ex}.nette-dump-array,.nette-dump-object{color:#C22}.nette-dump-string{color:#35D}.nette-dump-number{color:#090}.nette-dump-null,.nette-dump-bool{color:#850}.nette-dump-visibility{font-size:85%;color:#999}.nette-dump-indent{display:none}</style>

<!--[if lt IE 8]><style class="nette-debug">#nette-debug-bar img{display:none}#nette-debug-bar li{border-left:1px solid #DCD7C8;padding:0 3px}#nette-debug-logo span{background:#edeae0;display:inline}</style><![endif]-->


<script id="nette-debug-script">/*<![CDATA[*/var Nette=Nette||{};
(function(){var b=Nette.Query=function(a){if("string"===typeof a)a=this._find(document,a);else if(!a||a.nodeType||void 0===a.length||a===window)a=[a];for(var c=0,b=a.length;c<b;c++)a[c]&&(this[this.length++]=a[c])};b.factory=function(a){return new b(a)};b.prototype.length=0;b.prototype.find=function(a){return new b(this._find(this[0],a))};b.prototype._find=function(a,c){if(a&&c){if(document.querySelectorAll)return a.querySelectorAll(c);if("#"===c.charAt(0))return[document.getElementById(c.substring(1))];c=
c.split(".");var b=a.getElementsByTagName(c[0]||"*");if(c[1]){for(var d=[],e=RegExp("(^|\\s)"+c[1]+"(\\s|$)"),h=0,f=b.length;h<f;h++)e.test(b[h].className)&&d.push(b[h]);return d}return b}return[]};b.prototype.dom=function(){return this[0]};b.prototype.each=function(a){for(var c=0;c<this.length&&!1!==a.apply(this[c]);c++);return this};b.prototype.bind=function(a,c){if(document.addEventListener&&("mouseenter"===a||"mouseleave"===a)){var b=c;a="mouseenter"===a?"mouseover":"mouseout";c=function(a){for(var c=
a.relatedTarget;c;c=c.parentNode)if(c===this)return;b.call(this,a)}}return this.each(function(){var d=this,b=d.nette?d.nette:d.nette={},b=b.events=b.events||{};if(!b[a]){var h=b[a]=[],f=function(a){a.target||(a.target=a.srcElement);a.preventDefault||(a.preventDefault=function(){a.returnValue=!1});a.stopPropagation||(a.stopPropagation=function(){a.cancelBubble=!0});a.stopImmediatePropagation=function(){this.stopPropagation();c=h.length};for(var c=0;c<h.length;c++)h[c].call(d,a)};document.addEventListener?
d.addEventListener(a,f,!1):document.attachEvent&&d.attachEvent("on"+a,f)}b[a].push(c)})};b.prototype.addClass=function(a){return this.each(function(){this.className=this.className.replace(/^|\s+|$/g," ").replace(" "+a+" "," ")+" "+a})};b.prototype.removeClass=function(a){return this.each(function(){this.className=this.className.replace(/^|\s+|$/g," ").replace(" "+a+" "," ")})};b.prototype.hasClass=function(a){return this[0]&&-1<this[0].className.replace(/^|\s+|$/g," ").indexOf(" "+a+" ")};b.prototype.show=
function(){b.displays=b.displays||{};return this.each(function(){var a=this.tagName;b.displays[a]||(b.displays[a]=(new b(document.body.appendChild(document.createElement(a)))).css("display"));this.style.display=b.displays[a]})};b.prototype.hide=function(){return this.each(function(){this.style.display="none"})};b.prototype.css=function(a){if(this[0]&&this[0].currentStyle)return this[0].currentStyle[a];if(this[0]&&window.getComputedStyle)return document.defaultView.getComputedStyle(this[0],null).getPropertyValue(a)};
b.prototype.data=function(){if(this[0])return this[0].nette?this[0].nette:this[0].nette={}};b.prototype.val=function(){var a=this[0];if(a)if(a.nodeName){if("select"===a.nodeName.toLowerCase()){var c=a.selectedIndex,b=a.options;if(0>c)return null;if("select-one"===a.type)return b[c].value;c=0;a=[];for(d=b.length;c<d;c++)b[c].selected&&a.push(b[c].value);return a}if("checkbox"===a.type)return a.checked;if(a.value)return a.value.replace(/^\s+|\s+$/g,"")}else{for(var c=0,d=a.length;c<d;c++)if(this[c].checked)return this[c].value;
return null}};b.prototype._trav=function(a,c,g){for(c=c.split(".");a&&(1!==a.nodeType||c[0]&&a.tagName.toLowerCase()!==c[0]||c[1]&&!(new b(a)).hasClass(c[1]));)a=a[g];return new b(a||[])};b.prototype.closest=function(a){return this._trav(this[0],a,"parentNode")};b.prototype.prev=function(a){return this._trav(this[0]&&this[0].previousSibling,a,"previousSibling")};b.prototype.next=function(a){return this._trav(this[0]&&this[0].nextSibling,a,"nextSibling")};b.prototype.offset=function(a){if(a)return this.each(function(){for(var d=
this,c=-a.left||0,b=-a.top||0;d=d.offsetParent;)c+=d.offsetLeft,b+=d.offsetTop;this.style.left=-c+"px";this.style.top=-b+"px"});if(this[0]){for(var c=this[0],b={left:c.offsetLeft,top:c.offsetTop};c=c.offsetParent;)b.left+=c.offsetLeft,b.top+=c.offsetTop;return b}};b.prototype.position=function(a){if(a)return this.each(function(){this.nette&&this.nette.onmove&&this.nette.onmove.call(this,a);for(var b in a)this.style[b]=a[b]+"px"});if(this[0])return{left:this[0].offsetLeft,top:this[0].offsetTop,right:this[0].style.right?
parseInt(this[0].style.right,10):0,bottom:this[0].style.bottom?parseInt(this[0].style.bottom,10):0,width:this[0].offsetWidth,height:this[0].offsetHeight}};b.prototype.draggable=function(a){var c=this[0],g=document.documentElement,d;a=a||{};(a.handle?new b(a.handle):this).bind("mousedown",function(e){var h=new b(a.handle?c:this);e.preventDefault();e.stopPropagation();if(b.dragging)return g.onmouseup(e);var f=h.position(),k=a.rightEdge?f.right+e.clientX:f.left-e.clientX,l=a.bottomEdge?f.bottom+e.clientY:
f.top-e.clientY;b.dragging=!0;d=!1;g.onmousemove=function(b){b=b||event;d||(a.draggedClass&&h.addClass(a.draggedClass),a.start&&a.start(b,h),d=!0);var c={};c[a.rightEdge?"right":"left"]=a.rightEdge?k-b.clientX:b.clientX+k;c[a.bottomEdge?"bottom":"top"]=a.bottomEdge?l-b.clientY:b.clientY+l;h.position(c);return!1};g.onmouseup=function(c){d&&(a.draggedClass&&h.removeClass(a.draggedClass),a.stop&&a.stop(c||event,h));b.dragging=g.onmousemove=g.onmouseup=null;return!1}}).bind("click",function(a){d&&a.stopImmediatePropagation()});
return this}})();
(function(){var b=Nette.Query.factory,a=Nette.DebugPanel=function(a){this.id="nette-debug-panel-"+a;this.elem=b("#"+this.id)};a.PEEK="nette-mode-peek";a.FLOAT="nette-mode-float";a.WINDOW="nette-mode-window";a.FOCUSED="nette-focused";a.zIndex=2E4;a.prototype.init=function(){var a=this;this.elem.data().onmove=function(b){a.moveConstrains(this,b)};this.elem.draggable({rightEdge:!0,bottomEdge:!0,handle:this.elem.find("h1"),stop:function(){a.toFloat()}}).bind("mouseenter",function(b){a.focus()}).bind("mouseleave",function(b){a.blur()});
this.elem.find(".nette-icons").find("a").bind("click",function(b){"close"===this.rel?a.toPeek():a.toWindow();b.preventDefault()});this.restorePosition()};a.prototype.is=function(a){return this.elem.hasClass(a)};a.prototype.focus=function(b){var c=this.elem;this.is(a.WINDOW)?c.data().win.focus():(clearTimeout(c.data().displayTimeout),c.data().displayTimeout=setTimeout(function(){c.addClass(a.FOCUSED).show();c[0].style.zIndex=a.zIndex++;b&&b()},50))};a.prototype.blur=function(){var b=this.elem;b.removeClass(a.FOCUSED);
this.is(a.PEEK)&&(clearTimeout(b.data().displayTimeout),b.data().displayTimeout=setTimeout(function(){b.hide()},50))};a.prototype.toFloat=function(){this.elem.removeClass(a.WINDOW).removeClass(a.PEEK).addClass(a.FLOAT).show();this.reposition()};a.prototype.toPeek=function(){this.elem.removeClass(a.WINDOW).removeClass(a.FLOAT).addClass(a.PEEK).hide();document.cookie=this.id+"=; path=/"};a.prototype.toWindow=function(){var c=this.elem.offset();c.left+="number"===typeof window.screenLeft?window.screenLeft:
window.screenX+10;c.top+="number"===typeof window.screenTop?window.screenTop:window.screenY+50;var e=window.open("",this.id.replace(/-/g,"_"),"left="+c.left+",top="+c.top+",width="+c.width+",height="+(c.height+15)+",resizable=yes,scrollbars=yes");if(e){c=e.document;c.write('<!DOCTYPE html><meta charset="utf-8"><style>'+b("#nette-debug-style").dom().innerHTML+"</style><script>"+b("#nette-debug-script").dom().innerHTML+'\x3c/script><body id="nette-debug">');c.body.innerHTML='<div class="nette-panel nette-mode-window" id="'+
this.id+'">'+this.elem.dom().innerHTML+"</div>";var h=e.Nette.Debug.getPanel(this.id);e.Nette.Debug.initToggle();h.reposition();c.title=this.elem.find("h1").dom().innerHTML;var f=this;b([e]).bind("unload",function(){f.toPeek();e.close()});b(c).bind("keyup",function(a){27!==a.keyCode||(a.shiftKey||a.altKey||a.ctrlKey||a.metaKey)||e.close()});document.cookie=this.id+"=window; path=/";this.elem.hide().removeClass(a.FLOAT).removeClass(a.PEEK).addClass(a.WINDOW).data().win=e}};a.prototype.reposition=function(){if(this.is(a.WINDOW)){var b=
document.documentElement;window.resizeBy(b.scrollWidth-b.clientWidth,b.scrollHeight-b.clientHeight)}else b=this.elem.position(),b.width&&(this.elem.position({right:b.right,bottom:b.bottom}),document.cookie=this.id+"="+b.right+":"+b.bottom+"; path=/")};a.prototype.moveConstrains=function(a,b){var c=window.innerWidth||document.documentElement.clientWidth||document.body.clientWidth,f=window.innerHeight||document.documentElement.clientHeight||document.body.clientHeight;b.right=Math.min(Math.max(b.right,
-0.2*a.offsetWidth),c-0.8*a.offsetWidth);b.bottom=Math.min(Math.max(b.bottom,-0.2*a.offsetHeight),f-a.offsetHeight)};a.prototype.restorePosition=function(){var b=document.cookie.match(RegExp(this.id+"=(window|(-?[0-9]+):(-?[0-9]+))"));b&&b[2]?(this.elem.position({right:b[2],bottom:b[3]}),this.toFloat()):b?this.toWindow():this.elem.addClass(a.PEEK)};var c=Nette.DebugBar=function(){};c.prototype.id="nette-debug-bar";c.prototype.init=function(){var c=b("#"+this.id),e=this;c.data().onmove=function(a){e.moveConstrains(this,
a)};c.draggable({rightEdge:!0,bottomEdge:!0,draggedClass:"nette-dragged",stop:function(){e.savePosition()}});c.find("a").bind("click",function(b){if("close"===this.rel)e.close();else if(this.rel){var c=g.getPanel(this.rel);b.shiftKey?(c.toFloat(),c.toWindow()):c.is(a.FLOAT)?c.toPeek():(c.toFloat(),c.elem.position({right:c.elem.position().right+Math.round(100*Math.random())+20,bottom:c.elem.position().bottom+Math.round(100*Math.random())+20}))}b.preventDefault()}).bind("mouseenter",function(e){if(this.rel&&
"close"!==this.rel&&!c.hasClass("nette-dragged")){var f=g.getPanel(this.rel),k=b(this);f.focus(function(){f.is(a.PEEK)&&f.elem.position({right:f.elem.position().right-k.offset().left+f.elem.position().width-k.position().width-4+f.elem.offset().left,bottom:f.elem.position().bottom-c.offset().top+f.elem.position().height+4+f.elem.offset().top})})}}).bind("mouseleave",function(a){this.rel&&("close"!==this.rel&&!c.hasClass("nette-dragged"))&&g.getPanel(this.rel).blur()});this.restorePosition()};c.prototype.close=
function(){b("#nette-debug").hide();window.opera&&b("body").show()};c.prototype.moveConstrains=function(a,b){var c=window.innerWidth||document.documentElement.clientWidth||document.body.clientWidth,f=window.innerHeight||document.documentElement.clientHeight||document.body.clientHeight;b.right=Math.min(Math.max(b.right,0),c-a.offsetWidth);b.bottom=Math.min(Math.max(b.bottom,0),f-a.offsetHeight)};c.prototype.savePosition=function(){var a=b("#"+this.id).position();document.cookie=this.id+"="+a.right+
":"+a.bottom+"; path=/"};c.prototype.restorePosition=function(){var a=document.cookie.match(RegExp(this.id+"=(-?[0-9]+):(-?[0-9]+)"));a&&b("#"+this.id).position({right:a[1],bottom:a[2]})};var g=Nette.Debug={};g.init=function(){g.initResize();(new c).init();b(".nette-panel").each(function(){g.getPanel(this.id).init()})};g.getPanel=function(b){return new a(b.replace("nette-debug-panel-",""))};g.initResize=function(){b(window).bind("resize",function(){var a=b("#"+c.prototype.id);a.position({right:a.position().right,
bottom:a.position().bottom});b(".nette-panel").each(function(){g.getPanel(this.id).reposition()})})}})();
(function(){var b=Nette.Query.factory;(Nette.Dumper={}).init=function(){b(document.body).bind("click",function(a){for(var c=a.target;c&&(!c.tagName||0>c.className.indexOf("nette-toggle"));c=c.parentNode);if(c){var g=b(c).hasClass("nette-toggle-collapsed"),d=c.getAttribute("data-ref")||c.getAttribute("href",2),e=d&&"#"!==d?b(d):b(c).next(""),d=b(c).closest(".nette-panel"),h=d.position();c.className="nette-toggle"+(g?"":"-collapsed");e[g?"show":"hide"]();a.preventDefault();a=d.position();d.position({right:a.right-
a.width+h.width,bottom:a.bottom-a.height+h.height})}})}})();/*]]>*/</script>


<?php foreach($panels
as$id=>$panel):if(!$panel['panel'])continue;?>
	<div class="nette-panel" id="nette-debug-panel-<?php echo$panel['id']?>">
		<?php echo$panel['panel']?>
		<div class="nette-icons">
			<a href="#" title="open in window">&curren;</a>
			<a href="#" rel="close" title="close window">&times;</a>
		</div>
	</div>
<?php endforeach?>

<div id="nette-debug-bar">
	<ul>
		<li id="nette-debug-logo" title="PHP <?php echo
htmlSpecialChars(PHP_VERSION." |\n".(isset($_SERVER['SERVER_SOFTWARE'])?$_SERVER['SERVER_SOFTWARE']." |\n":'').(class_exists('Nette\Framework')?'Nette Framework '.Nette\Framework::VERSION.' ('.substr(Nette\Framework::REVISION,8).')':''))?>">&nbsp;<span>Nette Framework</span></li>
		<?php foreach($panels
as$panel):if(!$panel['tab'])continue;?>
		<?php if(!empty($panel['previous']))echo'</ul><ul class="nette-previous">';?>
		<li><?php if($panel['panel']):?><a href="#" rel="<?php echo$panel['id']?>"><?php echo
trim($panel['tab'])?></a><?php else:echo'<span>',trim($panel['tab']),'</span>';endif?></li>
		<?php endforeach?>
		<li><a href="#" rel="close" title="close debug bar">&times;</a></li>
	</ul>
</div>
<?php $output=ob_get_clean();?>


<script>
(function(onloadOrig) {
	window.onload = function() {
		if (typeof onloadOrig === 'function') onloadOrig();
		var debug = document.body.appendChild(document.createElement('div'));
		debug.id = 'nette-debug';
		debug.innerHTML = <?php echo
json_encode(Nette\Utils\Strings::fixEncoding($output))?>;
		for (var i = 0, scripts = debug.getElementsByTagName('script'); i < scripts.length; i++) eval(scripts[i].innerHTML);
		Nette.Dumper.init();
		Nette.Debug.init();
		debug.style.display = 'block';
	};
})(window.onload);
</script>

<!-- /Nette Debug Bar -->
<?php }}class
BlueScreen
extends
Nette\Object{private$panels=array();public$collapsePaths=array();function
addPanel($panel){if(!in_array($panel,$this->panels,TRUE)){$this->panels[]=$panel;}return$this;}function
render(\Exception$exception){$panels=$this->panels;$title=($exception
instanceof
Nette\FatalErrorException&&isset(Debugger::$errorTypes[$exception->getSeverity()]))?Debugger::$errorTypes[$exception->getSeverity()]:get_class($exception);$counter=0;?><!DOCTYPE html><!-- "' --></script></style></pre></xmp></table>
<html>
<head>
	<meta charset="utf-8">
	<meta name="robots" content="noindex">
	<meta name="generator" content="Nette Framework">

	<title><?php echo
htmlspecialchars($title)?></title><!-- <?php
$ex=$exception;echo
htmlspecialchars($ex->getMessage().($ex->getCode()?' #'.$ex->getCode():''),ENT_IGNORE);while($ex=$ex->getPrevious())echo
htmlspecialchars('; caused by '.get_class($ex).' '.$ex->getMessage().($ex->getCode()?' #'.$ex->getCode():''),ENT_IGNORE);?> -->

	<style type="text/css" class="nette-debug">html{overflow-y:scroll}body{margin:0 0 2em;padding:0}#netteBluescreen{font:9pt/1.5 Verdana,sans-serif;background:white;color:#333;position:absolute;left:0;top:0;width:100%;text-align:left}#netteBluescreen *{font:inherit;color:inherit;background:transparent;border:none;margin:0;padding:0;text-align:inherit;text-indent:0}#netteBluescreen b{font-weight:bold}#netteBluescreen i{font-style:italic}#netteBluescreen a{text-decoration:none;color:#328ADC;padding:2px 4px;margin:-2px -4px}#netteBluescreen a:hover,#netteBluescreen a:active,#netteBluescreen a:focus{color:#085AA3}#netteBluescreenIcon{position:absolute;right:.5em;top:.5em;z-index:20000;text-decoration:none;background:#CD1818;color:white!important;padding:3px}#netteBluescreenError{background:#CD1818;color:white;font:13pt/1.5 Verdana,sans-serif!important;display:block}#netteBluescreenError #netteBsSearch{color:#CD1818;font-size:.7em}#netteBluescreenError:hover #netteBsSearch{color:#ED8383}#netteBluescreen h1{font-size:18pt;font-weight:normal;text-shadow:1px 1px 0 rgba(0,0,0,.4);margin:.7em 0}#netteBluescreen h2{font:14pt/1.5 sans-serif!important;color:#888;margin:.6em 0}#netteBluescreen h3{font:bold 10pt/1.5 Verdana,sans-serif!important;margin:1em 0;padding:0}#netteBluescreen p,#netteBluescreen pre{margin:.8em 0}#netteBluescreen pre,#netteBluescreen code,#netteBluescreen table{font:9pt/1.5 Consolas,monospace!important}#netteBluescreen pre,#netteBluescreen table{background:#FDF5CE;padding:.4em .7em;border:1px dotted silver;overflow:auto}#netteBluescreen table pre{padding:0;margin:0;border:none}#netteBluescreen table{border-collapse:collapse;width:100%}#netteBluescreen td,#netteBluescreen th{vertical-align:top;text-align:left;padding:2px 6px;border:1px solid #e6dfbf}#netteBluescreen th{font-weight:bold}#netteBluescreen tr>:first-child{width:20%}#netteBluescreen tr:nth-child(2n),#netteBluescreen tr:nth-child(2n) pre{background-color:#F7F0CB}#netteBluescreen ol{margin:1em 0;padding-left:2.5em}#netteBluescreen ul{font:7pt/1.5 Verdana,sans-serif!important;padding:2em 4em;margin:1em 0 0;color:#777;background:#F6F5F3 url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFEAAAAjCAMAAADbuxbOAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAADBQTFRF/fz24d7Y7Onj5uLd9vPu3drUzMvG09LN39zW8e7o2NbQ3NnT29jS0M7J1tXQAAAApvmsFgAAABB0Uk5T////////////////////AOAjXRkAAAKlSURBVHja7FbbsqQgDAwENEgc//9vN+SCWDtbtXPmZR/Wc6o02mlC58LA9ckFAOszvMV8xNgyUjyXhojfMVKvRL0ZHavxXYy5JrmchMdzou8YlTClxajtK8ZGGpWRoBr1+gFjKfHkJPbizabLgzE3pH7Iu4K980xgFvlrVzMZoVBWhtvouCDdcTDmTgMCJdVxJ9MKO6XxnliM7hxi5lbj2ZVM4l8DqYyKoNLYcfqBB1/LpHYxEcfVG6ZpMDgyFUVWY/Q1sSYPpIdSAKWqLWL0XqWiMWc4hpH0OQOMOAgdycY4N9Sb7wWANQs3rsDSdLAYiuxi5siVfOhBWIrtH0G3kNaF/8Q4kCPE1kMucG/ZMUBUCOgiKJkPuWWTLGVgLGpwns1DraUayCtoBqERyaYtVsm85NActRooezvSLO/sKZP/nq8n4+xcyjNsRu8zW6KWpdb7wjiQd4WrtFZYFiKHENSmWp6xshh96c2RQ+c7Lt+qbijyEjHWUJ/pZsy8MGIUuzNiPySK2Gqoh6ZTRF6ko6q3nVTkaA//itIrDpW6l3SLo8juOmqMXkYknu5FdQxWbhCfKHEGDhxxyTVaXJF3ZjSl3jMksjSOOKmne9pI+mcG5QvaUJhI9HpkmRo2NpCrDJvsktRhRE2MM6F2n7dt4OaMUq8bCctk0+PoMRzL+1l5PZ2eyM/Owr86gf8z/tOM53lom5+nVcFuB+eJVzlXwAYy9TZ9s537tfqcsJWbEU4nBngZo6FfO9T9CdhfBtmk2dLiAy8uS4zwOpMx2HqYbTC+amNeAYTpsP4SIgvWfUBWXxn3CMHW3ffd7k3+YIkx7w0t/CVGvcPejoeOlzOWzeGbawOHqXQGUTMZRcfj4XPCgW9y/fuvVn8zD9P1QHzv80uAAQA0i3Jer7Jr7gAAAABJRU5ErkJggg==') 99% 10px no-repeat;border-top:1px solid #DDD}#netteBluescreen div.panel{padding:1px 25px}#netteBluescreen div.inner{background:#F4F3F1;padding:.1em 1em 1em;border-radius:8px;-moz-border-radius:8px;-webkit-border-radius:8px}#netteBluescreen .outer{overflow:auto}#netteBluescreen pre.php div{min-width:100%;float:left;_float:none;white-space:pre}#netteBluescreen .highlight{background:#CD1818;color:white;font-weight:bold;font-style:normal;display:block;padding:0 .4em;margin:0 -.4em}#netteBluescreen .line{color:#9F9C7F;font-weight:normal;font-style:normal}#netteBluescreen a[href^=editor\:]{color:inherit;border-bottom:1px dotted #C1D2E1}html.js #netteBluescreen .nette-collapsed{display:none}#netteBluescreen .nette-toggle,#netteBluescreen .nette-toggle-collapsed{cursor:pointer}#netteBluescreen .nette-toggle:after{content:" ▼";opacity:.4}#netteBluescreen .nette-toggle-collapsed:after{content:" ►";opacity:.4}#netteBluescreen .nette-dump-array,#netteBluescreen .nette-dump-object{color:#C22}#netteBluescreen .nette-dump-string{color:#35D}#netteBluescreen .nette-dump-number{color:#090}#netteBluescreen .nette-dump-null,#netteBluescreen .nette-dump-bool{color:#850}#netteBluescreen .nette-dump-visibility{font-size:85%;color:#998}#netteBluescreen .nette-dump-indent{display:none}#netteBluescreen pre.nette-dump div{padding-left:3ex}#netteBluescreen pre.nette-dump div div{border-left:1px solid rgba(0,0,0,.1);margin-left:.5ex}#netteBluescreen .caused{float:right;padding:.3em .6em;background:#df8075;border-radius:0 0 0 8px;white-space:nowrap}#netteBluescreen .caused a{color:white}</style>
</head>


<body>
<script>document.body.className+=" js";</script>
<div id="netteBluescreen">
	<a id="netteBluescreenIcon" href="#" class="nette-toggle"></a>
	<div>
		<div id="netteBluescreenError" class="panel">
			<h1><?php echo
htmlspecialchars($title),($exception->getCode()?' #'.$exception->getCode():'')?></h1>

			<p><?php echo
htmlspecialchars($exception->getMessage(),ENT_IGNORE)?> <a href="http://www.google.cz/search?sourceid=nette&amp;q=<?php echo
urlencode($title.' '.preg_replace('#\'.*\'|".*"#Us','',$exception->getMessage()))?>" id="netteBsSearch">search&#x25ba;</a></p>
		</div>

		<?php if($prev=$exception->getPrevious()):?>
		<div class="caused">
			<a href="#netteCaused">Caused by <?php echo
get_class($prev)?></a>
		</div>
		<?php endif?>


		<?php $ex=$exception;$level=0;?>
		<?php do{?>

			<?php if($level++):?>
			<div class="panel"<?php if($level===2)echo' id="netteCaused"'?>>
			<h2><a href="#netteBsPnl<?php echo++$counter?>" class="nette-toggle<?php echo($collapsed=$level>2)?'-collapsed':''?>">Caused by</a></h2>

			<div id="netteBsPnl<?php echo$counter?>" class="<?php echo$collapsed?'nette-collapsed ':''?>inner">
				<div class="panel">
					<h1><?php echo
htmlspecialchars(get_class($ex).($ex->getCode()?' #'.$ex->getCode():''))?></h1>

					<p><b><?php echo
htmlspecialchars($ex->getMessage(),ENT_IGNORE)?></b></p>
				</div>
			<?php endif?>


			<?php foreach($panels
as$panel):?>
			<?php $panel=call_user_func($panel,$ex);if(empty($panel['tab'])||empty($panel['panel']))continue;?>
			<?php if(!empty($panel['bottom'])){continue;}?>
			<div class="panel">
				<h2><a href="#netteBsPnl<?php echo++$counter?>" class="nette-toggle"><?php echo
htmlSpecialChars($panel['tab'])?></a></h2>

				<div id="netteBsPnl<?php echo$counter?>" class="inner">
				<?php echo$panel['panel']?>
			</div></div>
			<?php endforeach?>


			<?php $stack=$ex->getTrace();$expanded=NULL?>
			<?php if(!$exception
instanceof\ErrorException&&$this->isCollapsed($ex->getFile())){foreach($stack
as$key=>$row){if(isset($row['file'])&&!$this->isCollapsed($row['file'])){$expanded=$key;break;}}}?>

			<div class="panel">
			<h2><a href="#netteBsPnl<?php echo++$counter?>" class="nette-toggle<?php echo($collapsed=$expanded!==NULL)?'-collapsed':''?>">Source file</a></h2>

			<div id="netteBsPnl<?php echo$counter?>" class="<?php echo$collapsed?'nette-collapsed ':''?>inner">
				<p><b>File:</b> <?php echo
Helpers::editorLink($ex->getFile(),$ex->getLine())?></p>
				<?php if(is_file($ex->getFile())):?><?php echo
self::highlightFile($ex->getFile(),$ex->getLine(),15,isset($ex->context)?$ex->context:NULL)?><?php endif?>
			</div></div>


			<?php if(isset($stack[0]['class'])&&$stack[0]['class']==='Nette\Diagnostics\Debugger'&&($stack[0]['function']==='_shutdownHandler'||$stack[0]['function']==='_errorHandler'))unset($stack[0])?>
			<?php if($stack):?>
			<div class="panel">
				<h2><a href="#netteBsPnl<?php echo++$counter?>" class="nette-toggle">Call stack</a></h2>

				<div id="netteBsPnl<?php echo$counter?>" class="inner">
				<ol>
					<?php foreach($stack
as$key=>$row):?>
					<li><p>

					<?php if(isset($row['file'])&&is_file($row['file'])):?>
						<?php echo
Helpers::editorLink($row['file'],$row['line'])?>
					<?php else:?>
						<i>inner-code</i><?php if(isset($row['line']))echo':',$row['line']?>
					<?php endif?>

					<?php if(isset($row['file'])&&is_file($row['file'])):?><a href="#netteBsSrc<?php echo"$level-$key"?>" class="nette-toggle-collapsed">source</a>&nbsp; <?php endif?>

					<?php if(isset($row['object']))echo"<a href='#netteBsObj$level-$key' class='nette-toggle-collapsed'>"?>
					<?php if(isset($row['class']))echo
htmlspecialchars($row['class'].$row['type'])?>
					<?php if(isset($row['object']))echo'</a>'?>
					<?php echo
htmlspecialchars($row['function'])?>

					(<?php if(!empty($row['args'])):?><a href="#netteBsArgs<?php echo"$level-$key"?>" class="nette-toggle-collapsed">arguments</a><?php endif?>)
					</p>

					<?php if(isset($row['file'])&&is_file($row['file'])):?>
						<div <?php if($expanded!==$key)echo'class="nette-collapsed"';?> id="netteBsSrc<?php echo"$level-$key"?>"><?php echo
self::highlightFile($row['file'],$row['line'])?></div>
					<?php endif?>

					<?php if(isset($row['object'])):?>
						<div class="nette-collapsed outer" id="netteBsObj<?php echo"$level-$key"?>"><?php echo
Dumper::toHtml($row['object']);?></div>
					<?php endif?>

					<?php if(!empty($row['args'])):?>
						<div class="nette-collapsed outer" id="netteBsArgs<?php echo"$level-$key"?>">
						<table>
						<?php

try{$r=isset($row['class'])?new\ReflectionMethod($row['class'],$row['function']):new\ReflectionFunction($row['function']);$params=$r->getParameters();}catch(\Exception$e){$params=array();}foreach($row['args']as$k=>$v){echo'<tr><th>',htmlspecialchars(isset($params[$k])?'$'.$params[$k]->name:"#$k"),'</th><td>';echo
Dumper::toHtml($v);echo"</td></tr>\n";}?>
						</table>
						</div>
					<?php endif?>
					</li>
					<?php endforeach?>
				</ol>
			</div></div>
			<?php endif?>


			<?php if(isset($ex->context)&&is_array($ex->context)):?>
			<div class="panel">
			<h2><a href="#netteBsPnl<?php echo++$counter?>" class="nette-toggle-collapsed">Variables</a></h2>

			<div id="netteBsPnl<?php echo$counter?>" class="nette-collapsed inner">
			<div class="outer">
			<table>
			<?php

foreach($ex->context
as$k=>$v){echo'<tr><th>$',htmlspecialchars($k),'</th><td>',Dumper::toHtml($v),"</td></tr>\n";}?>
			</table>
			</div>
			</div></div>
			<?php endif?>

		<?php }while($ex=$ex->getPrevious());?>
		<?php while(--$level)echo'</div></div>'?>


		<?php $bottomPanels=array()?>
		<?php foreach($panels
as$panel):?>
		<?php $panel=call_user_func($panel,NULL);if(empty($panel['tab'])||empty($panel['panel']))continue;?>
		<?php if(!empty($panel['bottom'])){$bottomPanels[]=$panel;continue;}?>
		<div class="panel">
			<h2><a href="#netteBsPnl<?php echo++$counter?>" class="nette-toggle-collapsed"><?php echo
htmlSpecialChars($panel['tab'])?></a></h2>

			<div id="netteBsPnl<?php echo$counter?>" class="nette-collapsed inner">
			<?php echo$panel['panel']?>
		</div></div>
		<?php endforeach?>


		<div class="panel">
		<h2><a href="#netteBsPnl<?php echo++$counter?>" class="nette-toggle-collapsed">Environment</a></h2>

		<div id="netteBsPnl<?php echo$counter?>" class="nette-collapsed inner">
			<h3><a href="#netteBsPnl<?php echo++$counter?>" class="nette-toggle">$_SERVER</a></h3>
			<div id="netteBsPnl<?php echo$counter?>" class="outer">
			<table>
			<?php

foreach($_SERVER
as$k=>$v)echo'<tr><th>',htmlspecialchars($k),'</th><td>',Dumper::toHtml($v),"</td></tr>\n";?>
			</table>
			</div>


			<h3><a href="#netteBsPnl<?php echo++$counter?>" class="nette-toggle">$_SESSION</a></h3>
			<div id="netteBsPnl<?php echo$counter?>" class="outer">
			<?php if(empty($_SESSION)):?>
			<p><i>empty</i></p>
			<?php else:?>
			<table>
			<?php

foreach($_SESSION
as$k=>$v)echo'<tr><th>',htmlspecialchars($k),'</th><td>',$k==='__NF'?'<i>Nette Session</i>':Dumper::toHtml($v),"</td></tr>\n";?>
			</table>
			<?php endif?>
			</div>


			<?php if(!empty($_SESSION['__NF']['DATA'])):?>
			<h3><a href="#netteBsPnl<?php echo++$counter?>" class="nette-toggle">Nette Session</a></h3>
			<div id="netteBsPnl<?php echo$counter?>" class="outer">
			<table>
			<?php

foreach($_SESSION['__NF']['DATA']as$k=>$v)echo'<tr><th>',htmlspecialchars($k),'</th><td>',Dumper::toHtml($v),"</td></tr>\n";?>
			</table>
			</div>
			<?php endif?>


			<?php
$list=get_defined_constants(TRUE);if(!empty($list['user'])):?>
			<h3><a href="#netteBsPnl<?php echo++$counter?>" class="nette-toggle-collapsed">Constants</a></h3>
			<div id="netteBsPnl<?php echo$counter?>" class="outer nette-collapsed">
			<table>
			<?php

foreach($list['user']as$k=>$v){echo'<tr><th>',htmlspecialchars($k),'</th>';echo'<td>',Dumper::toHtml($v),"</td></tr>\n";}?>
			</table>
			</div>
			<?php endif?>


			<h3><a href="#netteBsPnl<?php echo++$counter?>" class="nette-toggle-collapsed">Included files</a> (<?php echo
count(get_included_files())?>)</h3>
			<div id="netteBsPnl<?php echo$counter?>" class="outer nette-collapsed">
			<table>
			<?php

foreach(get_included_files()as$v){echo'<tr><td>',htmlspecialchars($v,ENT_IGNORE),"</td></tr>\n";}?>
			</table>
			</div>


			<h3><a href="#netteBsPnl<?php echo++$counter?>" class="nette-toggle-collapsed">Configuration options</a></h3>
			<div id="netteBsPnl<?php echo$counter?>" class="outer nette-collapsed">
			<?php ob_start();@phpinfo(INFO_CONFIGURATION|INFO_MODULES);echo
preg_replace('#^.+<body>|</body>.+\z#s','',ob_get_clean())?>
			</div>
		</div></div>


		<div class="panel">
		<h2><a href="#netteBsPnl<?php echo++$counter?>" class="nette-toggle-collapsed">HTTP request</a></h2>

		<div id="netteBsPnl<?php echo$counter?>" class="nette-collapsed inner">
			<?php if(function_exists('apache_request_headers')):?>
			<h3>Headers</h3>
			<div class="outer">
			<table>
			<?php

foreach(apache_request_headers()as$k=>$v)echo'<tr><th>',htmlspecialchars($k),'</th><td>',htmlspecialchars($v),"</td></tr>\n";?>
			</table>
			</div>
			<?php endif?>


			<?php foreach(array('_GET','_POST','_COOKIE')as$name):?>
			<h3>$<?php echo
htmlspecialchars($name)?></h3>
			<?php if(empty($GLOBALS[$name])):?>
			<p><i>empty</i></p>
			<?php else:?>
			<div class="outer">
			<table>
			<?php

foreach($GLOBALS[$name]as$k=>$v)echo'<tr><th>',htmlspecialchars($k),'</th><td>',Dumper::toHtml($v),"</td></tr>\n";?>
			</table>
			</div>
			<?php endif?>
			<?php endforeach?>
		</div></div>


		<div class="panel">
		<h2><a href="#netteBsPnl<?php echo++$counter?>" class="nette-toggle-collapsed">HTTP response</a></h2>

		<div id="netteBsPnl<?php echo$counter?>" class="nette-collapsed inner">
			<h3>Headers</h3>
			<?php if(headers_list()):?>
			<pre><?php

foreach(headers_list()as$s)echo
htmlspecialchars($s,ENT_IGNORE),'<br>';?></pre>
			<?php else:?>
			<p><i>no headers</i></p>
			<?php endif?>
		</div></div>


		<?php foreach($bottomPanels
as$panel):?>
		<div class="panel">
			<h2><a href="#netteBsPnl<?php echo++$counter?>" class="nette-toggle"><?php echo
htmlSpecialChars($panel['tab'])?></a></h2>

			<div id="netteBsPnl<?php echo$counter?>" class="inner">
			<?php echo$panel['panel']?>
		</div></div>
		<?php endforeach?>


		<ul>
			<li>Report generated at <?php echo@date('Y/m/d H:i:s',Debugger::$time)?></li>
			<?php if(preg_match('#^https?://#',Debugger::$source)):?>
				<li><a href="<?php echo
htmlSpecialChars(Debugger::$source,ENT_IGNORE|ENT_QUOTES)?>"><?php echo
htmlSpecialChars(Debugger::$source,ENT_IGNORE)?></a></li>
			<?php elseif(Debugger::$source):?>
				<li><?php echo
htmlSpecialChars(Debugger::$source,ENT_IGNORE)?></li>
			<?php endif?>
			<li>PHP <?php echo
htmlSpecialChars(PHP_VERSION)?></li>
			<?php if(isset($_SERVER['SERVER_SOFTWARE'])):?><li><?php echo
htmlSpecialChars($_SERVER['SERVER_SOFTWARE'])?></li><?php endif?>
			<?php if(class_exists('Nette\Framework')):?><li><?php echo
htmlSpecialChars('Nette Framework '.Nette\Framework::VERSION)?> <i>(revision <?php echo
htmlSpecialChars(Nette\Framework::REVISION)?>)</i></li><?php endif?>
		</ul>
	</div>
</div>

<script type="text/javascript">/*<![CDATA[*/var bs=document.getElementById("netteBluescreen");document.body.appendChild(bs);document.onkeyup=function(b){b=b||window.event;27!=b.keyCode||(b.shiftKey||b.altKey||b.ctrlKey||b.metaKey)||document.getElementById("netteBluescreenIcon").click()};
for(var i=0,styles=document.styleSheets;i<styles.length;i++)"nette-debug"!==(styles[i].owningElement||styles[i].ownerNode).className?(styles[i].oldDisabled=styles[i].disabled,styles[i].disabled=!0):styles[i].addRule?styles[i].addRule(".nette-collapsed","display: none"):styles[i].insertRule(".nette-collapsed { display: none }",0);
bs.onclick=function(b){b=b||window.event;for(var a=b.target||b.srcElement;a&&(!a.tagName||0>a.className.indexOf("nette-toggle"));a=a.parentNode);if(!a)return!0;var d=-1<a.className.indexOf("nette-toggle-collapsed"),c=a.getAttribute("data-ref")||a.getAttribute("href",2);if(c&&"#"!==c)dest=document.getElementById(c.substring(1));else for(dest=a.nextSibling;dest&&1!==dest.nodeType;dest=dest.nextSibling);a.className="nette-toggle"+(d?"":"-collapsed");dest.style.display=d?"div"===dest.tagName.toLowerCase()?
"block":"inline":"none";if("netteBluescreenIcon"===a.id)for(a=0,c=document.styleSheets;a<c.length;a++)"nette-debug"!==(c[a].owningElement||c[a].ownerNode).className&&(c[a].disabled=d?!0:c[a].oldDisabled);b.preventDefault?b.preventDefault():b.returnValue=!1;b.stopPropagation?b.stopPropagation():b.cancelBubble=!0};/*]]>*/</script>
</body>
</html>
<?php }static
function
highlightFile($file,$line,$lines=15,$vars=array()){$source=@file_get_contents($file);if($source){return
static::highlightPhp($source,$line,$lines,$vars);}}static
function
highlightPhp($source,$line,$lines=15,$vars=array()){if(function_exists('ini_set')){ini_set('highlight.comment','#998; font-style: italic');ini_set('highlight.default','#000');ini_set('highlight.html','#06B');ini_set('highlight.keyword','#D24; font-weight: bold');ini_set('highlight.string','#080');}$source=str_replace(array("\r\n","\r"),"\n",$source);$source=explode("\n",highlight_string($source,TRUE));$spans=1;$out=$source[0];$source=explode('<br />',$source[1]);array_unshift($source,NULL);$start=$i=max(1,$line-floor($lines*2/3));while(--$i>=1){if(preg_match('#.*(</?span[^>]*>)#',$source[$i],$m)){if($m[1]!=='</span>'){$spans++;$out.=$m[1];}break;}}$source=array_slice($source,$start,$lines,TRUE);end($source);$numWidth=strlen((string)key($source));foreach($source
as$n=>$s){$spans+=substr_count($s,'<span')-substr_count($s,'</span');$s=str_replace(array("\r","\n"),array('',''),$s);preg_match_all('#<[^>]+>#',$s,$tags);if($n==$line){$out.=sprintf("<span class='highlight'>%{$numWidth}s:    %s\n</span>%s",$n,strip_tags($s),implode('',$tags[0]));}else{$out.=sprintf("<span class='line'>%{$numWidth}s:</span>    %s\n",$n,$s);}}$out.=str_repeat('</span>',$spans).'</code>';$out=preg_replace_callback('#">\$(\w+)(&nbsp;)?</span>#',function($m)use($vars){return
isset($vars[$m[1]])?'" title="'.str_replace('"','&quot;',strip_tags(Dumper::toHtml($vars[$m[1]]))).$m[0]:$m[0];},$out);return"<pre class='php'><div>$out</div></pre>";}function
isCollapsed($file){foreach($this->collapsePaths
as$path){if(strpos(strtr($file,'\\','/'),strtr("$path/",'\\','/'))===0){return
TRUE;}}return
FALSE;}}final
class
Debugger{public
static$productionMode=self::DETECT;public
static$consoleMode;public
static$time;public
static$source;public
static$editor='editor://open/?file=%file&line=%line';public
static$browser;public
static$maxDepth=3;public
static$maxLen=150;public
static$showLocation=FALSE;public
static$consoleColors;const
DEVELOPMENT=FALSE,PRODUCTION=TRUE,DETECT=NULL;public
static$blueScreen;public
static$strictMode=FALSE;public
static$scream=FALSE;public
static$onFatalError=array();private
static$enabled=FALSE;private
static$lastError=FALSE;public
static$errorTypes=array(E_ERROR=>'Fatal Error',E_USER_ERROR=>'User Error',E_RECOVERABLE_ERROR=>'Recoverable Error',E_CORE_ERROR=>'Core Error',E_COMPILE_ERROR=>'Compile Error',E_PARSE=>'Parse Error',E_WARNING=>'Warning',E_CORE_WARNING=>'Core Warning',E_COMPILE_WARNING=>'Compile Warning',E_USER_WARNING=>'User Warning',E_NOTICE=>'Notice',E_USER_NOTICE=>'User Notice',E_STRICT=>'Strict standards',E_DEPRECATED=>'Deprecated',E_USER_DEPRECATED=>'User Deprecated');public
static$logger;public
static$fireLogger;public
static$logDirectory;public
static$email;public
static$mailer=array('Nette\Diagnostics\Logger','defaultMailer');public
static$emailSnooze=172800;const
DEBUG='debug',INFO='info',WARNING='warning',ERROR='error',CRITICAL='critical';public
static$bar;final
function
__construct(){throw
new
Nette\StaticClassException;}static
function
enable($mode=NULL,$logDirectory=NULL,$email=NULL){self::$time=isset($_SERVER['REQUEST_TIME_FLOAT'])?$_SERVER['REQUEST_TIME_FLOAT']:microtime(TRUE);if(isset($_SERVER['REQUEST_URI'])){self::$source=(isset($_SERVER['HTTPS'])&&strcasecmp($_SERVER['HTTPS'],'off')?'https://':'http://').(isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:(isset($_SERVER['SERVER_NAME'])?$_SERVER['SERVER_NAME']:'')).$_SERVER['REQUEST_URI'];}else{self::$source=empty($_SERVER['argv'])?'CLI':'CLI: '.implode(' ',$_SERVER['argv']);}self::$consoleColors=&Dumper::$terminalColors;error_reporting(E_ALL|E_STRICT);if(is_bool($mode)){self::$productionMode=$mode;}elseif($mode!==self::DETECT||self::$productionMode===NULL){$list=is_string($mode)?preg_split('#[,\s]+#',$mode):(array)$mode;if(!isset($_SERVER['HTTP_X_FORWARDED_FOR'])){$list[]='127.0.0.1';$list[]='::1';}self::$productionMode=!in_array(isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:php_uname('n'),$list,TRUE);}if(is_string($logDirectory)){self::$logDirectory=realpath($logDirectory);if(self::$logDirectory===FALSE){echo
__METHOD__."() error: Log directory is not found or is not directory.\n";exit(254);}}elseif($logDirectory===FALSE||self::$logDirectory===NULL){self::$logDirectory=FALSE;}if(self::$logDirectory){ini_set('error_log',self::$logDirectory.'/php_error.log');}if(function_exists('ini_set')){ini_set('display_errors',!self::$productionMode);ini_set('html_errors',FALSE);ini_set('log_errors',FALSE);}elseif(ini_get('display_errors')!=!self::$productionMode&&ini_get('display_errors')!==(self::$productionMode?'stderr':'stdout')){echo
__METHOD__."() error: Unable to set 'display_errors' because function ini_set() is disabled.\n";exit(254);}if($email){if(!is_string($email)&&!is_array($email)){echo
__METHOD__."() error: Email address must be a string.\n";exit(254);}self::$email=$email;}if(!self::$enabled){register_shutdown_function(array(__CLASS__,'_shutdownHandler'));set_exception_handler(array(__CLASS__,'_exceptionHandler'));set_error_handler(array(__CLASS__,'_errorHandler'));foreach(array('Nette\Diagnostics\Bar','Nette\Diagnostics\BlueScreen','Nette\Diagnostics\DefaultBarPanel','Nette\Diagnostics\Dumper','Nette\Diagnostics\FireLogger','Nette\Diagnostics\Helpers','Nette\Diagnostics\Logger','Nette\FatalErrorException','Nette\Utils\Html','Nette\Utils\Strings')as$class){class_exists($class);}self::$enabled=TRUE;}}static
function
getBlueScreen(){if(!self::$blueScreen){self::$blueScreen=new
BlueScreen;self::$blueScreen->collapsePaths[]=NETTE_DIR;self::$blueScreen->addPanel(function($e){if($e
instanceof
Nette\Templating\FilterException){return
array('tab'=>'Template','panel'=>'<p><b>File:</b> '.Helpers::editorLink($e->sourceFile,$e->sourceLine).'</p>'.($e->sourceLine?BlueScreen::highlightFile($e->sourceFile,$e->sourceLine):''));}elseif($e
instanceof
Nette\Utils\NeonException&&preg_match('#line (\d+)#',$e->getMessage(),$m)){if($item=Helpers::findTrace($e->getTrace(),'Nette\Config\Adapters\NeonAdapter::load')){return
array('tab'=>'NEON','panel'=>'<p><b>File:</b> '.Helpers::editorLink($item['args'][0],$m[1]).'</p>'.BlueScreen::highlightFile($item['args'][0],$m[1]));}elseif($item=Helpers::findTrace($e->getTrace(),'Nette\Utils\Neon::decode')){return
array('tab'=>'NEON','panel'=>BlueScreen::highlightPhp($item['args'][0],$m[1]));}}});}return
self::$blueScreen;}static
function
getBar(){if(!self::$bar){self::$bar=new
Bar;self::$bar->addPanel(new
DefaultBarPanel('time'));self::$bar->addPanel(new
DefaultBarPanel('memory'));self::$bar->addPanel(new
DefaultBarPanel('errors'),__CLASS__.':errors');self::$bar->addPanel(new
DefaultBarPanel('dumps'),__CLASS__.':dumps');}return
self::$bar;}static
function
setLogger($logger){self::$logger=$logger;}static
function
getLogger(){if(!self::$logger){self::$logger=new
Logger;self::$logger->directory=&self::$logDirectory;self::$logger->email=&self::$email;self::$logger->mailer=&self::$mailer;self::$logger->emailSnooze=&self::$emailSnooze;}return
self::$logger;}static
function
getFireLogger(){if(!self::$fireLogger){self::$fireLogger=new
FireLogger;}return
self::$fireLogger;}static
function
isEnabled(){return
self::$enabled;}static
function
log($message,$priority=self::INFO){if(self::$logDirectory===FALSE){return;}elseif(!self::$logDirectory){throw
new
Nette\InvalidStateException('Logging directory is not specified in Nette\Diagnostics\Debugger::$logDirectory.');}$exceptionFilename=NULL;if($message
instanceof\Exception){$exception=$message;while($exception){$tmp[]=($exception
instanceof
Nette\FatalErrorException?'Fatal error: '.$exception->getMessage():get_class($exception).": ".$exception->getMessage())." in ".$exception->getFile().":".$exception->getLine();$exception=$exception->getPrevious();}$exception=$message;$message=implode($tmp,"\ncaused by ");$hash=md5(preg_replace('~(Resource id #)\d+~','$1',$exception));$exceptionFilename="exception-".@date('Y-m-d-H-i-s')."-$hash.html";foreach(new\DirectoryIterator(self::$logDirectory)as$entry){if(strpos($entry,$hash)){$exceptionFilename=$entry;$saved=TRUE;break;}}}elseif(!is_string($message)){$message=Dumper::toText($message);}if($exceptionFilename){$exceptionFilename=self::$logDirectory.'/'.$exceptionFilename;if(empty($saved)&&$logHandle=@fopen($exceptionFilename,'w')){ob_start();ob_start(function($buffer)use($logHandle){fwrite($logHandle,$buffer);},4096);self::getBlueScreen()->render($exception);ob_end_flush();ob_end_clean();fclose($logHandle);}}self::getLogger()->log(array(@date('[Y-m-d H-i-s]'),trim($message),self::$source?' @  '.self::$source:NULL,$exceptionFilename?' @@  '.basename($exceptionFilename):NULL),$priority);return$exceptionFilename?strtr($exceptionFilename,'\\/',DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR):NULL;}static
function
_shutdownHandler(){if(!self::$enabled){return;}$error=error_get_last();if(in_array($error['type'],array(E_ERROR,E_CORE_ERROR,E_COMPILE_ERROR,E_PARSE))){self::_exceptionHandler(Helpers::fixStack(new
Nette\FatalErrorException($error['message'],0,$error['type'],$error['file'],$error['line'],NULL)));}if(!connection_aborted()&&!self::$productionMode&&self::isHtmlMode()){self::getBar()->render();}}static
function
_exceptionHandler(\Exception$exception){if(!headers_sent()){$protocol=isset($_SERVER['SERVER_PROTOCOL'])?$_SERVER['SERVER_PROTOCOL']:'HTTP/1.1';$code=isset($_SERVER['HTTP_USER_AGENT'])&&strpos($_SERVER['HTTP_USER_AGENT'],'MSIE ')!==FALSE?503:500;header("$protocol $code",TRUE,$code);}try{if(self::$productionMode){try{self::log($exception,self::ERROR);}catch(\Exception$e){echo'FATAL ERROR: unable to log error';}if(self::isHtmlMode()){?>
<!DOCTYPE html>
<meta charset="utf-8">
<meta name=robots content=noindex>
<meta name=generator content="Nette Framework">
<style>body{color:#333;background:white;width:500px;margin:100px auto}h1{font:bold 47px/1.5 sans-serif;margin:.6em 0}p{font:21px/1.5 Georgia,serif;margin:1.5em 0}small{font-size:70%;color:gray}</style>

<title>Server Error</title>

<h1>Server Error</h1>

<p>We're sorry! The server encountered an internal error and was unable to complete your request. Please try again later.</p>

<p><small>error 500</small></p>
<?php }else{echo"ERROR: the server encountered an internal error and was unable to complete your request.\n";}}else{if(!connection_aborted()&&self::isHtmlMode()){self::getBlueScreen()->render($exception);self::getBar()->render();}elseif(connection_aborted()||!self::fireLog($exception)){$file=self::log($exception,self::ERROR);if(!headers_sent()){header("X-Nette-Error-Log: $file");}echo"$exception\n".($file?"(stored in $file)\n":'');if(self::$browser){exec(self::$browser.' '.escapeshellarg($file));}}}foreach(self::$onFatalError
as$handler){call_user_func($handler,$exception);}}catch(\Exception$e){if(self::$productionMode){echo
self::isHtmlMode()?'<meta name=robots content=noindex>FATAL ERROR':'FATAL ERROR';}else{echo"FATAL ERROR: thrown ",get_class($e),': ',$e->getMessage(),"\nwhile processing ",get_class($exception),': ',$exception->getMessage(),"\n";}}self::$enabled=FALSE;exit(254);}static
function
_errorHandler($severity,$message,$file,$line,$context){if(self::$scream){error_reporting(E_ALL|E_STRICT);}if(self::$lastError!==FALSE&&($severity&error_reporting())===$severity){self::$lastError=new\ErrorException($message,0,$severity,$file,$line);return
NULL;}if($severity===E_RECOVERABLE_ERROR||$severity===E_USER_ERROR){if(Helpers::findTrace(debug_backtrace(PHP_VERSION_ID>=50306?DEBUG_BACKTRACE_IGNORE_ARGS:FALSE),'*::__toString')){$previous=isset($context['e'])&&$context['e']instanceof\Exception?$context['e']:NULL;self::_exceptionHandler(new
Nette\FatalErrorException($message,0,$severity,$file,$line,$context,$previous));}throw
new
Nette\FatalErrorException($message,0,$severity,$file,$line,$context);}elseif(($severity&error_reporting())!==$severity){return
FALSE;}elseif(!self::$productionMode&&(is_bool(self::$strictMode)?self::$strictMode:((self::$strictMode&$severity)===$severity))){self::_exceptionHandler(new
Nette\FatalErrorException($message,0,$severity,$file,$line,$context));}$message='PHP '.(isset(self::$errorTypes[$severity])?self::$errorTypes[$severity]:'Unknown error').": $message";$count=&self::getBar()->getPanel(__CLASS__.':errors')->data["$message|$file|$line"];if($count++){return
NULL;}elseif(self::$productionMode){self::log("$message in $file:$line",self::ERROR);return
NULL;}else{self::fireLog(new\ErrorException($message,0,$severity,$file,$line));return
self::isHtmlMode()?NULL:FALSE;}return
FALSE;}static
function
toStringException(\Exception$exception){if(self::$enabled){self::_exceptionHandler($exception);}else{trigger_error($exception->getMessage(),E_USER_ERROR);}}static
function
tryError(){trigger_error(__METHOD__.'() is deprecated; use own error handler instead.',E_USER_DEPRECATED);if(!self::$enabled&&self::$lastError===FALSE){set_error_handler(array(__CLASS__,'_errorHandler'));}self::$lastError=NULL;}static
function
catchError(&$error){trigger_error(__METHOD__.'() is deprecated; use own error handler instead.',E_USER_DEPRECATED);if(!self::$enabled&&self::$lastError!==FALSE){restore_error_handler();}$error=self::$lastError;self::$lastError=FALSE;return(bool)$error;}static
function
dump($var,$return=FALSE){if($return){ob_start();Dumper::dump($var,array(Dumper::DEPTH=>self::$maxDepth,Dumper::TRUNCATE=>self::$maxLen));return
ob_get_clean();}elseif(!self::$productionMode){Dumper::dump($var,array(Dumper::DEPTH=>self::$maxDepth,Dumper::TRUNCATE=>self::$maxLen,Dumper::LOCATION=>self::$showLocation));}return$var;}static
function
timer($name=NULL){static$time=array();$now=microtime(TRUE);$delta=isset($time[$name])?$now-$time[$name]:0;$time[$name]=$now;return$delta;}static
function
barDump($var,$title=NULL){if(!self::$productionMode){$dump=array();foreach((is_array($var)?$var:array(''=>$var))as$key=>$val){$dump[$key]=Dumper::toHtml($val);}self::getBar()->getPanel(__CLASS__.':dumps')->data[]=array('title'=>$title,'dump'=>$dump);}return$var;}static
function
fireLog($message){if(!self::$productionMode){return
self::getFireLogger()->log($message);}}private
static
function
isHtmlMode(){return
empty($_SERVER['HTTP_X_REQUESTED_WITH'])&&PHP_SAPI!=='cli'&&!preg_match('#^Content-Type: (?!text/html)#im',implode("\n",headers_list()));}static
function
addPanel(IBarPanel$panel,$id=NULL){return
self::getBar()->addPanel($panel,$id);}}final
class
DefaultBarPanel
extends
Nette\Object
implements
IBarPanel{private$id;public$data;function
__construct($id){$this->id=$id;}function
getTab(){ob_start();$data=$this->data;if($this->id==='time'){?>
<span title="Execution time"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAJ6SURBVDjLjZO7T1NhGMY7Mji6uJgYt8bElTjof6CDg4sMSqIxJsRGB5F4TwQSIg1QKC0KWmkZEEsKtEcSxF5ohV5pKSicXqX3aqGn957z+PUEGopiGJ583/A+v3znvPkJAAjWR0VNJG0kGhKahCFhXcN3YBFfx8Kry6ym4xIzce88/fbWGY2k5WRb77UTTbWuYA9gDGg7EVmSIOF4g5T7HZKuMcSW5djWDyL0uRf0dCc8inYYxTcw9fAiCMBYB3gVj1z7gLhNTjKCqHkYP79KENC9Bq3uxrrqORzy+9D3tPAAccspVx1gWg0KbaZFbGllWFM+xrKkFQudV0CeDfJsjN4+C2nracjunoPq5VXIBrowMK4V1gG1LGyWdbZwCalsBYUyh2KFQzpXxVqkAGswD3+qBDpZwow9iYE5v26/VwfUQnnznyhvjguQYabIIpKpYD1ahI8UTT92MUSFuP5Z/9TBTgOgFrVjp3nakaG/0VmEfpX58pwzjUEquNk362s+PP8XYD/KpYTBHmRg9Wch0QX1R80dCZhYipudYQY2Auib8RmODVCa4hfUK4ngaiiLNFNFdKeCWWscXZMbWy9Unv9/gsIQU09a4pwvUeA3Uapy2C2wCKXL0DqTePLexbWPOv79E8f0UWrencZ2poxciUWZlKssB4bcHeE83NsFuMgpo2iIpMuNa1TNu4XjhggWvb+R2K3wZdLlAZl8Fd9jRb5sD+Xx0RJBx5gdom6VsMEFDyWF0WyCeSOFcDKPnRxZYTQL5Rc/nn1w4oFsBaIhC3r6FRh5erPRhYMyHdeFw4C6zkRhmijM7CnMu0AUZonCDCnRJBqSus5/ABD6Ba5CkQS8AAAAAElFTkSuQmCC"
/><?php echo
number_format((microtime(TRUE)-Debugger::$time)*1000,1,'.',' ')?> ms</span>
<?php }elseif($this->id==='memory'){?>
<span title="The peak of allocated memory"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAGvSURBVDjLpZO7alZREEbXiSdqJJDKYJNCkPBXYq12prHwBezSCpaidnY+graCYO0DpLRTQcR3EFLl8p+9525xgkRIJJApB2bN+gZmqCouU+NZzVef9isyUYeIRD0RTz482xouBBBNHi5u4JlkgUfx+evhxQ2aJRrJ/oFjUWysXeG45cUBy+aoJ90Sj0LGFY6anw2o1y/mK2ZS5pQ50+2XiBbdCvPk+mpw2OM/Bo92IJMhgiGCox+JeNEksIC11eLwvAhlzuAO37+BG9y9x3FTuiWTzhH61QFvdg5AdAZIB3Mw50AKsaRJYlGsX0tymTzf2y1TR9WwbogYY3ZhxR26gBmocrxMuhZNE435FtmSx1tP8QgiHEvj45d3jNlONouAKrjjzWaDv4CkmmNu/Pz9CzVh++Yd2rIz5tTnwdZmAzNymXT9F5AtMFeaTogJYkJfdsaaGpyO4E62pJ0yUCtKQFxo0hAT1JU2CWNOJ5vvP4AIcKeao17c2ljFE8SKEkVdWWxu42GYK9KE4c3O20pzSpyyoCx4v/6ECkCTCqccKorNxR5uSXgQnmQkw2Xf+Q+0iqQ9Ap64TwAAAABJRU5ErkJggg=="
/><?php echo
function_exists('memory_get_peak_usage')?number_format(memory_get_peak_usage()/1000000,2,'.',' '):'n/a';?> MB</span>
<?php }elseif($this->id==='dumps'&&$this->data){?>
<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAIASURBVDjLpVPPaxNREJ6Vt01caH4oWk1T0ZKlGIo9RG+BUsEK4kEP/Q8qPXnpqRdPBf8A8Wahhx7FQ0GF9FJ6UksqwfTSBDGyB5HkkphC9tfb7jfbtyQQTx142byZ75v5ZnZWC4KALmICPy+2DkvKIX2f/POz83LxCL7nrz+WPNcll49DrhM9v7xdO9JW330DuXrrqkFSgig5iR2Cfv3t3gNxOnv5BwU+eZ5HuON5/PMPJZKJ+yKQfpW0S7TxdC6WJaWkyvff1LDaFRAeLZj05MHsiPTS6hua0PUqtwC5sHq9zv9RYWl+nu5cETcnJ1M0M5WlWq3GsX6/T+VymRzHDluZiGYAAsw0TQahV8uyyGq1qFgskm0bHIO/1+sx1rFtchJhArwEyIQ1Gg2WD2A6nWawHQJVDIWgIJfLhQowTIeE9D0mKAU8qPC0220afsWFQoH93W6X7yCDJ+DEBeBmsxnPIJVKxWQVUwry+XyUwBlKMKwA8jqdDhOVCqVAzQDVvXAXhOdGBFgymYwrGoZBmUyGjxCCdF0fSahaFdgoTHRxfTveMCXvWfkuE3Y+f40qhgT/nMitupzApdvT18bu+YeDQwY9Xl4aG9/d/URiMBhQq/dvZMeVghtT17lSZW9/rAKsvPa/r9Fc2dw+Pe0/xI6kM9mT5vtXy+Nw2kU/5zOGRpvuMIu0YAAAAABJRU5ErkJggg==" />variables
<?php }elseif($this->id==='errors'&&$this->data){?>
<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAIsSURBVDjLpVNLSJQBEP7+h6uu62vLVAJDW1KQTMrINQ1vPQzq1GOpa9EppGOHLh0kCEKL7JBEhVCHihAsESyJiE4FWShGRmauu7KYiv6Pma+DGoFrBQ7MzGFmPr5vmDFIYj1mr1WYfrHPovA9VVOqbC7e/1rS9ZlrAVDYHig5WB0oPtBI0TNrUiC5yhP9jeF4X8NPcWfopoY48XT39PjjXeF0vWkZqOjd7LJYrmGasHPCCJbHwhS9/F8M4s8baid764Xi0Ilfp5voorpJfn2wwx/r3l77TwZUvR+qajXVn8PnvocYfXYH6k2ioOaCpaIdf11ivDcayyiMVudsOYqFb60gARJYHG9DbqQFmSVNjaO3K2NpAeK90ZCqtgcrjkP9aUCXp0moetDFEeRXnYCKXhm+uTW0CkBFu4JlxzZkFlbASz4CQGQVBFeEwZm8geyiMuRVntzsL3oXV+YMkvjRsydC1U+lhwZsWXgHb+oWVAEzIwvzyVlk5igsi7DymmHlHsFQR50rjl+981Jy1Fw6Gu0ObTtnU+cgs28AKgDiy+Awpj5OACBAhZ/qh2HOo6i+NeA73jUAML4/qWux8mt6NjW1w599CS9xb0mSEqQBEDAtwqALUmBaG5FV3oYPnTHMjAwetlWksyByaukxQg2wQ9FlccaK/OXA3/uAEUDp3rNIDQ1ctSk6kHh1/jRFoaL4M4snEMeD73gQx4M4PsT1IZ5AfYH68tZY7zv/ApRMY9mnuVMvAAAAAElFTkSuQmCC"
/><span class="nette-warning"><?php echo
array_sum($data)?> errors</span>
<?php }return
ob_get_clean();}function
getPanel(){ob_start();$data=$this->data;if($this->id==='dumps'){?>
<style class="nette-debug">#nette-debug .nette-DumpPanel h2{font:11pt/1.5 sans-serif;margin:0;padding:2px 8px;background:#3484d2;color:white}#nette-debug .nette-DumpPanel table{width:100%}</style>


<h1>Dumped variables</h1>

<div class="nette-inner nette-DumpPanel">
<?php foreach($data
as$item):?>
	<?php if($item['title']):?>
	<h2><?php echo
htmlspecialchars($item['title'])?></h2>
	<?php endif?>

	<table>
	<?php $i=0?>
	<?php foreach($item['dump']as$key=>$dump):?>
	<tr class="<?php echo$i++%
2?'nette-alt':''?>">
		<th><?php echo
htmlspecialchars($key)?></th>
		<td><?php echo$dump?></td>
	</tr>
	<?php endforeach?>
	</table>
<?php endforeach?>
</div>
<?php }elseif($this->id==='errors'){?>
<h1>Errors</h1>

<div class="nette-inner">
<table>
<?php $i=0?>
<?php foreach($data
as$item=>$count):list($message,$file,$line)=explode('|',$item)?>
<tr class="<?php echo$i++%
2?'nette-alt':''?>">
	<td class="nette-right"><?php echo$count?"$count\xC3\x97":''?></td>
	<td><pre><?php echo
htmlspecialchars($message,ENT_IGNORE),' in ',Helpers::editorLink($file,$line)?></pre></td>
</tr>
<?php endforeach?>
</table>
</div>
<?php }return
ob_get_clean();}}class
Dumper{const
DEPTH='depth',TRUNCATE='truncate',COLLAPSE='collapse',COLLAPSE_COUNT='collapsecount',LOCATION='location';public
static$terminalColors=array('bool'=>'1;33','null'=>'1;33','number'=>'1;32','string'=>'1;36','array'=>'1;31','key'=>'1;37','object'=>'1;31','visibility'=>'1;30','resource'=>'1;37','indent'=>'1;30');public
static$resources=array('stream'=>'stream_get_meta_data','stream-context'=>'stream_context_get_options','curl'=>'curl_getinfo');static
function
dump($var,array$options=NULL){if(PHP_SAPI!=='cli'&&!preg_match('#^Content-Type: (?!text/html)#im',implode("\n",headers_list()))){echo
self::toHtml($var,$options);}elseif(self::detectColors()){echo
self::toTerminal($var,$options);}else{echo
self::toText($var,$options);}return$var;}static
function
toHtml($var,array$options=NULL){list($file,$line,$code)=empty($options[self::LOCATION])?NULL:self::findLocation();return'<pre class="nette-dump"'.($file?' title="'.htmlspecialchars("$code\nin file $file on line $line",ENT_IGNORE|ENT_QUOTES).'">':'>').self::dumpVar($var,(array)$options+array(self::DEPTH=>4,self::TRUNCATE=>150,self::COLLAPSE=>FALSE,self::COLLAPSE_COUNT=>7)).($file?'<small>in <a href="editor://open/?file='.rawurlencode($file)."&amp;line=$line\">".htmlspecialchars($file,ENT_IGNORE).":$line</a></small>":'')."</pre>\n";}static
function
toText($var,array$options=NULL){return
htmlspecialchars_decode(strip_tags(self::toHtml($var,$options)),ENT_QUOTES);}static
function
toTerminal($var,array$options=NULL){return
htmlspecialchars_decode(strip_tags(preg_replace_callback('#<span class="nette-dump-(\w+)">|</span>#',function($m){return"\033[".(isset($m[1],Dumper::$terminalColors[$m[1]])?Dumper::$terminalColors[$m[1]]:'0')."m";},self::toHtml($var,$options))),ENT_QUOTES);}private
static
function
dumpVar(&$var,array$options,$level=0){if(method_exists(__CLASS__,$m='dump'.gettype($var))){return
self::$m($var,$options,$level);}else{return"<span>unknown type</span>\n";}}private
static
function
dumpNull(){return"<span class=\"nette-dump-null\">NULL</span>\n";}private
static
function
dumpBoolean(&$var){return'<span class="nette-dump-bool">'.($var?'TRUE':'FALSE')."</span>\n";}private
static
function
dumpInteger(&$var){return"<span class=\"nette-dump-number\">$var</span>\n";}private
static
function
dumpDouble(&$var){$var=var_export($var,TRUE);return'<span class="nette-dump-number">'.$var.(strpos($var,'.')===FALSE?'.0':'')."</span>\n";}private
static
function
dumpString(&$var,$options){return'<span class="nette-dump-string">'.self::encodeString($options[self::TRUNCATE]&&strlen($var)>$options[self::TRUNCATE]?substr($var,0,$options[self::TRUNCATE]).' ... ':$var).'</span>'.(strlen($var)>1?' ('.strlen($var).')':'')."\n";}private
static
function
dumpArray(&$var,$options,$level){static$marker;if($marker===NULL){$marker=uniqid("\x00",TRUE);}$out='<span class="nette-dump-array">array</span> (';if(empty($var)){return$out."0)\n";}elseif(isset($var[$marker])){return$out.(count($var)-1).") [ <i>RECURSION</i> ]\n";}elseif(!$options[self::DEPTH]||$level<$options[self::DEPTH]){$collapsed=$level?count($var)>=$options[self::COLLAPSE_COUNT]:$options[self::COLLAPSE];$out='<span class="nette-toggle'.($collapsed?'-collapsed">':'">').$out.count($var).")</span>\n<div".($collapsed?' class="nette-collapsed"':'').">";$var[$marker]=TRUE;foreach($var
as$k=>&$v){if($k!==$marker){$out.='<span class="nette-dump-indent">   '.str_repeat('|  ',$level).'</span>'.'<span class="nette-dump-key">'.(preg_match('#^\w+\z#',$k)?$k:self::encodeString($k)).'</span> => '.self::dumpVar($v,$options,$level+1);}}unset($var[$marker]);return$out.'</div>';}else{return$out.count($var).") [ ... ]\n";}}private
static
function
dumpObject(&$var,$options,$level){if($var
instanceof\Closure){$rc=new\ReflectionFunction($var);$fields=array();foreach($rc->getParameters()as$param){$fields[]='$'.$param->getName();}$fields=array('file'=>$rc->getFileName(),'line'=>$rc->getStartLine(),'variables'=>$rc->getStaticVariables(),'parameters'=>implode(', ',$fields));}elseif($var
instanceof\SplFileInfo){$fields=array('path'=>$var->getPathname());}elseif($var
instanceof\SplObjectStorage){$fields=array();foreach(clone$var
as$obj){$fields[]=array('object'=>$obj,'data'=>$var[$obj]);}}else{$fields=(array)$var;}static$list=array();$out='<span class="nette-dump-object">'.get_class($var)."</span> (".count($fields).')';if(empty($fields)){return$out."\n";}elseif(in_array($var,$list,TRUE)){return$out." { <i>RECURSION</i> }\n";}elseif(!$options[self::DEPTH]||$level<$options[self::DEPTH]||$var
instanceof\Closure){$collapsed=$level?count($fields)>=$options[self::COLLAPSE_COUNT]:$options[self::COLLAPSE];$out='<span class="nette-toggle'.($collapsed?'-collapsed">':'">').$out."</span>\n<div".($collapsed?' class="nette-collapsed"':'').">";$list[]=$var;foreach($fields
as$k=>&$v){$vis='';if($k[0]==="\x00"){$vis=' <span class="nette-dump-visibility">'.($k[1]==='*'?'protected':'private').'</span>';$k=substr($k,strrpos($k,"\x00")+1);}$out.='<span class="nette-dump-indent">   '.str_repeat('|  ',$level).'</span>'.'<span class="nette-dump-key">'.(preg_match('#^\w+\z#',$k)?$k:self::encodeString($k))."</span>$vis => ".self::dumpVar($v,$options,$level+1);}array_pop($list);return$out.'</div>';}else{return$out." { ... }\n";}}private
static
function
dumpResource(&$var,$options,$level){$type=get_resource_type($var);$out='<span class="nette-dump-resource">'.htmlSpecialChars($type).' resource</span>';if(isset(self::$resources[$type])){$out="<span class=\"nette-toggle-collapsed\">$out</span>\n<div class=\"nette-collapsed\">";foreach(call_user_func(self::$resources[$type],$var)as$k=>$v){$out.='<span class="nette-dump-indent">   '.str_repeat('|  ',$level).'</span>'.'<span class="nette-dump-key">'.htmlSpecialChars($k)."</span> => ".self::dumpVar($v,$options,$level+1);}return$out.'</div>';}return"$out\n";}private
static
function
encodeString($s){static$table;if($table===NULL){foreach(array_merge(range("\x00","\x1F"),range("\x7F","\xFF"))as$ch){$table[$ch]='\x'.str_pad(dechex(ord($ch)),2,'0',STR_PAD_LEFT);}$table["\\"]='\\\\';$table["\r"]='\r';$table["\n"]='\n';$table["\t"]='\t';}if(preg_match('#[^\x09\x0A\x0D\x20-\x7E\xA0-\x{10FFFF}]#u',$s)||preg_last_error()){$s=strtr($s,$table);}return'"'.htmlSpecialChars($s,ENT_NOQUOTES).'"';}private
static
function
findLocation(){foreach(debug_backtrace(PHP_VERSION_ID>=50306?DEBUG_BACKTRACE_IGNORE_ARGS:FALSE)as$item){if(isset($item['file'])&&strpos($item['file'],__DIR__)===0){continue;}elseif(!isset($item['file'],$item['line'])||!is_file($item['file'])){break;}else{$lines=file($item['file']);$line=$lines[$item['line']-1];return
array($item['file'],$item['line'],preg_match('#\w*dump(er::\w+)?\(.*\)#i',$line,$m)?$m[0]:$line);}}}private
static
function
detectColors(){return
self::$terminalColors&&(getenv('ConEmuANSI')==='ON'||getenv('ANSICON')!==FALSE||(defined('STDOUT')&&function_exists('posix_isatty')&&posix_isatty(STDOUT)));}}class
FireLogger
extends
Nette\Object{const
DEBUG='debug',INFO='info',WARNING='warning',ERROR='error',CRITICAL='critical';private
static$payload=array('logs'=>array());static
function
log($message,$priority=self::DEBUG){if(!isset($_SERVER['HTTP_X_FIRELOGGER'])||headers_sent()){return
FALSE;}$item=array('name'=>'PHP','level'=>$priority,'order'=>count(self::$payload['logs']),'time'=>str_pad(number_format((microtime(TRUE)-Debugger::$time)*1000,1,'.',' '),8,'0',STR_PAD_LEFT).' ms','template'=>'','message'=>'','style'=>'background:#767ab6');$args=func_get_args();if(isset($args[0])&&is_string($args[0])){$item['template']=array_shift($args);}if(isset($args[0])&&$args[0]instanceof\Exception){$e=array_shift($args);$trace=$e->getTrace();if(isset($trace[0]['class'])&&$trace[0]['class']==='Nette\Diagnostics\Debugger'&&($trace[0]['function']==='_shutdownHandler'||$trace[0]['function']==='_errorHandler')){unset($trace[0]);}$file=str_replace(dirname(dirname(dirname($e->getFile()))),"\xE2\x80\xA6",$e->getFile());$item['template']=($e
instanceof\ErrorException?'':get_class($e).': ').$e->getMessage().($e->getCode()?' #'.$e->getCode():'').' in '.$file.':'.$e->getLine();$item['pathname']=$e->getFile();$item['lineno']=$e->getLine();}else{$trace=debug_backtrace();if(isset($trace[1]['class'])&&$trace[1]['class']==='Nette\Diagnostics\Debugger'&&($trace[1]['function']==='fireLog')){unset($trace[0]);}foreach($trace
as$frame){if(isset($frame['file'])&&is_file($frame['file'])){$item['pathname']=$frame['file'];$item['lineno']=$frame['line'];break;}}}$item['exc_info']=array('','',array());$item['exc_frames']=array();foreach($trace
as$frame){$frame+=array('file'=>NULL,'line'=>NULL,'class'=>NULL,'type'=>NULL,'function'=>NULL,'object'=>NULL,'args'=>NULL);$item['exc_info'][2][]=array($frame['file'],$frame['line'],"$frame[class]$frame[type]$frame[function]",$frame['object']);$item['exc_frames'][]=$frame['args'];}if(isset($args[0])&&in_array($args[0],array(self::DEBUG,self::INFO,self::WARNING,self::ERROR,self::CRITICAL),TRUE)){$item['level']=array_shift($args);}$item['args']=$args;self::$payload['logs'][]=self::jsonDump($item,-1);foreach(str_split(base64_encode(@json_encode(self::$payload)),4990)as$k=>$v){header("FireLogger-de11e-$k:$v");}return
TRUE;}private
static
function
jsonDump(&$var,$level=0){if(is_bool($var)||is_null($var)||is_int($var)||is_float($var)){return$var;}elseif(is_string($var)){if(Debugger::$maxLen&&strlen($var)>Debugger::$maxLen){$var=substr($var,0,Debugger::$maxLen)." \xE2\x80\xA6 ";}return
Nette\Utils\Strings::fixEncoding($var);}elseif(is_array($var)){static$marker;if($marker===NULL){$marker=uniqid("\x00",TRUE);}if(isset($var[$marker])){return"\xE2\x80\xA6RECURSION\xE2\x80\xA6";}elseif($level<Debugger::$maxDepth||!Debugger::$maxDepth){$var[$marker]=TRUE;$res=array();foreach($var
as$k=>&$v){if($k!==$marker){$res[self::jsonDump($k)]=self::jsonDump($v,$level+1);}}unset($var[$marker]);return$res;}else{return" \xE2\x80\xA6 ";}}elseif(is_object($var)){$arr=(array)$var;static$list=array();if(in_array($var,$list,TRUE)){return"\xE2\x80\xA6RECURSION\xE2\x80\xA6";}elseif($level<Debugger::$maxDepth||!Debugger::$maxDepth){$list[]=$var;$res=array("\x00"=>'(object) '.get_class($var));foreach($arr
as$k=>&$v){if($k[0]==="\x00"){$k=substr($k,strrpos($k,"\x00")+1);}$res[self::jsonDump($k)]=self::jsonDump($v,$level+1);}array_pop($list);return$res;}else{return" \xE2\x80\xA6 ";}}elseif(is_resource($var)){return"resource ".get_resource_type($var);}else{return"unknown type";}}}final
class
Helpers{static
function
editorLink($file,$line){if(Debugger::$editor&&is_file($file)){$dir=dirname(strtr($file,'/',DIRECTORY_SEPARATOR));$base=isset($_SERVER['SCRIPT_FILENAME'])?dirname(dirname(strtr($_SERVER['SCRIPT_FILENAME'],'/',DIRECTORY_SEPARATOR))):dirname($dir);if(substr($dir,0,strlen($base))===$base){$dir='...'.substr($dir,strlen($base));}return
Nette\Utils\Html::el('a')->href(strtr(Debugger::$editor,array('%file'=>rawurlencode($file),'%line'=>$line)))->title("$file:$line")->setHtml(htmlSpecialChars(rtrim($dir,DIRECTORY_SEPARATOR),ENT_IGNORE).DIRECTORY_SEPARATOR.'<b>'.htmlSpecialChars(basename($file),ENT_IGNORE).'</b>'.($line?":$line":''));}else{return
Nette\Utils\Html::el('span')->setText($file.($line?":$line":''));}}static
function
findTrace(array$trace,$method,&$index=NULL){$m=explode('::',$method);foreach($trace
as$i=>$item){if(isset($item['function'])&&$item['function']===end($m)&&isset($item['class'])===isset($m[1])&&(!isset($item['class'])||$item['class']===$m[0]||$m[0]==='*'||is_subclass_of($item['class'],$m[0]))){$index=$i;return$item;}}}static
function
fixStack($exception){if(function_exists('xdebug_get_function_stack')){$stack=array();foreach(array_slice(array_reverse(xdebug_get_function_stack()),2,-1)as$row){$frame=array('file'=>$row['file'],'line'=>$row['line'],'function'=>isset($row['function'])?$row['function']:'*unknown*','args'=>array());if(!empty($row['class'])){$frame['type']=isset($row['type'])&&$row['type']==='dynamic'?'->':'::';$frame['class']=$row['class'];}$stack[]=$frame;}$ref=new\ReflectionProperty('Exception','trace');$ref->setAccessible(TRUE);$ref->setValue($exception,$stack);}return$exception;}static
function
htmlDump($var){trigger_error(__METHOD__.'() is deprecated; use Nette\Diagnostics\Dumper::toHtml() instead.',E_USER_DEPRECATED);return
Dumper::toHtml($var);}static
function
clickableDump($var){trigger_error(__METHOD__.'() is deprecated; use Nette\Diagnostics\Dumper::toHtml() instead.',E_USER_DEPRECATED);return
Dumper::toHtml($var);}static
function
textDump($var){trigger_error(__METHOD__.'() is deprecated; use Nette\Diagnostics\Dumper::toText() instead.',E_USER_DEPRECATED);return
Dumper::toText($var);}}class
Logger
extends
Nette\Object{const
DEBUG='debug',INFO='info',WARNING='warning',ERROR='error',CRITICAL='critical';public$emailSnooze=172800;public$mailer=array(__CLASS__,'defaultMailer');public$directory;public$email;function
log($message,$priority=NULL){if(!is_dir($this->directory)){throw
new
Nette\DirectoryNotFoundException("Directory '$this->directory' is not found or is not directory.");}if(is_array($message)){$message=implode(' ',$message);}$message=preg_replace('#\s*\r?\n\s*#',' ',trim($message));$res=error_log($message.PHP_EOL,3,$this->directory.'/'.strtolower($priority?:self::INFO).'.log');if(($priority===self::ERROR||$priority===self::CRITICAL)&&$this->email&&$this->mailer&&@filemtime($this->directory.'/email-sent')+$this->emailSnooze<time()&&@file_put_contents($this->directory.'/email-sent','sent')){call_user_func($this->mailer,$message,implode(', ',(array)$this->email));}return$res;}static
function
defaultMailer($message,$email){$host=php_uname('n');foreach(array('HTTP_HOST','SERVER_NAME','HOSTNAME')as$item){if(isset($_SERVER[$item])){$host=$_SERVER[$item];break;}}$parts=str_replace(array("\r\n","\n"),array("\n",PHP_EOL),array('headers'=>implode("\n",array("From: noreply@$host",'X-Mailer: Nette Framework','Content-Type: text/plain; charset=UTF-8','Content-Transfer-Encoding: 8bit'))."\n",'subject'=>"PHP: An error occurred on the server $host",'body'=>"[".@date('Y-m-d H:i:s')."] $message"));mail($email,$parts['subject'],$parts['body'],$parts['headers']);}}}namespace Nette\Forms{use
Nette;class
ControlGroup
extends
Nette\Object{protected$controls;private$options=array();function
__construct(){$this->controls=new\SplObjectStorage;}function
add(){foreach(func_get_args()as$num=>$item){if($item
instanceof
IControl){$this->controls->attach($item);}elseif($item
instanceof\Traversable||is_array($item)){foreach($item
as$control){$this->controls->attach($control);}}else{throw
new
Nette\InvalidArgumentException("Only IFormControl items are allowed, the #$num parameter is invalid.");}}return$this;}function
getControls(){return
iterator_to_array($this->controls);}function
setOption($key,$value){if($value===NULL){unset($this->options[$key]);}else{$this->options[$key]=$value;}return$this;}final
function
getOption($key,$default=NULL){return
isset($this->options[$key])?$this->options[$key]:$default;}final
function
getOptions(){return$this->options;}}}namespace Nette\Forms\Controls{use
Nette;use
Nette\Forms\IControl;use
Nette\Utils\Html;use
Nette\Forms\Form;abstract
class
BaseControl
extends
Nette\ComponentModel\Component
implements
IControl{public
static$idMask='frm-%s';public$caption;protected$value;protected$control;protected$label;private$errors=array();protected$disabled=FALSE;private$omitted=FALSE;private$rules;private$translator=TRUE;private$options=array();function
__construct($caption=NULL){$this->monitor('Nette\Forms\Form');parent::__construct();$this->control=Html::el('input',array('type'=>NULL,'name'=>NULL));$this->label=Html::el('label');$this->caption=$caption;$this->rules=new
Nette\Forms\Rules($this);$this->setValue(NULL);}protected
function
attached($form){if(!$this->isDisabled()&&$form
instanceof
Form&&$form->isAnchored()&&$form->isSubmitted()){$this->loadHttpData();}}function
getForm($need=TRUE){return$this->lookup('Nette\Forms\Form',$need);}function
loadHttpData(){$this->setValue($this->getHttpData());}function
getHttpData($type=Form::DATA_TEXT,$htmlTail=NULL){return$this->getForm()->getHttpData($this->getHtmlName().$htmlTail,$type);}function
getHtmlName(){return
Nette\Forms\Helpers::generateHtmlName($this->lookupPath('Nette\Forms\Form'));}function
setValue($value){$this->value=$value;return$this;}function
getValue(){return$this->value;}function
isFilled(){$value=$this->getValue();return$value!==NULL&&$value!==array()&&$value!=='';}function
setDefaultValue($value){$form=$this->getForm(FALSE);if($this->isDisabled()||!$form||!$form->isAnchored()||!$form->isSubmitted()){$this->setValue($value);}return$this;}function
setDisabled($value=TRUE){if($this->disabled=(bool)$value){$this->omitted=TRUE;$this->setValue(NULL);}return$this;}function
isDisabled(){return$this->disabled===TRUE;}function
setOmitted($value=TRUE){$this->omitted=(bool)$value;return$this;}function
isOmitted(){return$this->omitted;}function
getControl(){$this->setOption('rendered',TRUE);$el=clone$this->control;return$el->addAttributes(array('name'=>$this->getHtmlName(),'id'=>$this->getHtmlId(),'required'=>$this->isRequired(),'disabled'=>$this->isDisabled(),'data-nette-rules'=>Nette\Forms\Helpers::exportRules($this->rules)));}function
getLabel($caption=NULL){$label=clone$this->label;$label->for=$this->getHtmlId();$label->setText($this->translate($caption===NULL?$this->caption:$caption));return$label;}final
function
getControlPrototype(){return$this->control;}final
function
getLabelPrototype(){return$this->label;}function
setHtmlId($id){$this->control->id=$id;return$this;}function
getHtmlId(){if(!isset($this->control->id)){$this->control->id=sprintf(self::$idMask,$this->lookupPath(NULL));}return$this->control->id;}function
setAttribute($name,$value=TRUE){$this->control->$name=$value;return$this;}function
setTranslator(Nette\Localization\ITranslator$translator=NULL){$this->translator=$translator;return$this;}final
function
getTranslator(){if($this->translator===TRUE){return$this->getForm(FALSE)?$this->getForm()->getTranslator():NULL;}return$this->translator;}function
translate($s,$count=NULL){$translator=$this->getTranslator();return$translator===NULL||$s==NULL||$s
instanceof
Html?$s:$translator->translate((string)$s,$count);}function
addRule($operation,$message=NULL,$arg=NULL){$this->rules->addRule($operation,$message,$arg);return$this;}function
addCondition($operation,$value=NULL){return$this->rules->addCondition($operation,$value);}function
addConditionOn(IControl$control,$operation,$value=NULL){return$this->rules->addConditionOn($control,$operation,$value);}final
function
getRules(){return$this->rules;}function
setRequired($value=TRUE){$this->rules->setRequired($value);return$this;}final
function
isRequired(){return$this->rules->isRequired();}function
validate(){if($this->isDisabled()){return;}$this->cleanErrors();foreach($this->rules->validate()as$error){$this->addError($error);}}function
addError($message){$this->errors[]=$message;}function
getError(){return$this->errors?implode(' ',array_unique($this->errors)):NULL;}function
getErrors(){return
array_unique($this->errors);}function
hasErrors(){return(bool)$this->errors;}function
cleanErrors(){$this->errors=array();}function
setOption($key,$value){if($value===NULL){unset($this->options[$key]);}else{$this->options[$key]=$value;}return$this;}final
function
getOption($key,$default=NULL){return
isset($this->options[$key])?$this->options[$key]:$default;}final
function
getOptions(){return$this->options;}}class
Button
extends
BaseControl{function
isFilled(){return(bool)$this->getValue();}function
getLabel($caption=NULL){return
NULL;}function
getControl($caption=NULL){$this->setOption('rendered',TRUE);$el=clone$this->control;return$el->addAttributes(array('type'=>'button','name'=>$this->getHtmlName(),'disabled'=>$this->isDisabled(),'value'=>$this->translate($caption===NULL?$this->caption:$caption)));}}class
Checkbox
extends
BaseControl{function
setValue($value){if(!is_scalar($value)&&$value!==NULL){throw
new
Nette\InvalidArgumentException('Value must be scalar or NULL, '.gettype($value).' given.');}$this->value=(bool)$value;return$this;}function
isFilled(){return$this->getValue()!==FALSE;}function
getControl(){return
parent::getControl()->type('checkbox')->checked($this->value);}}class
HiddenField
extends
BaseControl{function
__construct(){if(func_num_args()){throw
new
Nette\DeprecatedException('The "forced value" has been deprecated.');}parent::__construct();}function
setValue($value){if(!is_scalar($value)&&$value!==NULL&&!method_exists($value,'__toString')){throw
new
Nette\InvalidArgumentException('Value must be scalar or NULL, '.gettype($value).' given.');}$this->value=(string)$value;return$this;}function
getControl(){$this->setOption('rendered',TRUE);$el=clone$this->control;return$el->addAttributes(array('type'=>'hidden','name'=>$this->getHtmlName(),'disabled'=>$this->isDisabled(),'value'=>$this->value));}function
getLabel($caption=NULL){return
NULL;}function
addError($message){$this->getForm()->addError($message);}}class
CsrfProtection
extends
HiddenField{const
PROTECTION='Nette\Forms\Controls\CsrfProtection::validateCsrf';public$session;function
__construct($message){parent::__construct();$this->setOmitted()->addRule(self::PROTECTION,$message);$this->monitor('Nette\Application\UI\Presenter');}protected
function
attached($parent){parent::attached($parent);if(!$this->session&&$parent
instanceof
Nette\Application\UI\Presenter){$this->session=$parent->getSession();}}function
getToken(){$session=$this->getSession()->getSection(__CLASS__);if(!isset($session->token)){$session->token=Nette\Utils\Strings::random();}return$session->token;}function
getControl(){return
parent::getControl()->value($this->getToken());}static
function
validateCsrf(CsrfProtection$control){return$control->getValue()===$control->getToken();}private
function
getSession(){if(!$this->session){$this->session=new
Nette\Http\Session($this->getForm()->httpRequest,new
Nette\Http\Response);}return$this->session;}}class
SubmitButton
extends
Button
implements
Nette\Forms\ISubmitterControl{public$onClick;public$onInvalidClick;private$validationScope;function
__construct($caption=NULL){parent::__construct($caption);$this->setOmitted(TRUE);}function
loadHttpData(){parent::loadHttpData();if($this->value!==NULL){$this->getForm()->setSubmittedBy($this);}}function
isSubmittedBy(){return$this->getForm()->isSubmitted()===$this;}function
setValidationScope($scope=NULL){if($scope===NULL||$scope===TRUE){$this->validationScope=NULL;}else{$this->validationScope=array();foreach($scope?:array()as$control){if(!$control
instanceof
Nette\Forms\Container&&!$control
instanceof
Nette\Forms\IControl){throw
new
Nette\InvalidArgumentException('Validation scope accepts only Nette\Forms\Container or Nette\Forms\IControl instances.');}$this->validationScope[]=$control;}}return$this;}final
function
getValidationScope(){return$this->validationScope;}function
click(){$this->onClick($this);}function
getControl($caption=NULL){$scope=array();foreach((array)$this->validationScope
as$control){$scope[]=$control->lookupPath('Nette\Forms\Form');}return
parent::getControl($caption)->addAttributes(array('type'=>'submit','formnovalidate'=>$this->validationScope!==NULL,'data-nette-validation-scope'=>$scope?json_encode($scope):NULL));}}class
ImageButton
extends
SubmitButton{function
__construct($src=NULL,$alt=NULL){parent::__construct();$this->control->src=$src;$this->control->alt=$alt;}function
loadHttpData(){parent::loadHttpData();$this->value=$this->value?array((int)array_shift($this->value),(int)array_shift($this->value)):FALSE;}function
getHtmlName(){return
parent::getHtmlName().'[]';}function
getControl($caption=NULL){return
parent::getControl($caption)->type('image');}}class
SelectBox
extends
BaseControl{const
VALID=':selectBoxValid';private$items=array();protected$flattenItems=array();private$prompt=FALSE;function
__construct($label=NULL,array$items=NULL,$size=NULL){parent::__construct($label);$this->control->size=$size>1?(int)$size:NULL;if($items!==NULL){$this->setItems($items);}}function
loadHttpData(){$this->value=$this->getHttpData();if($this->value!==NULL){if(is_array($this->disabled)&&isset($this->disabled[$this->value])){$this->value=NULL;}else{$this->value=key(array($this->value=>NULL));}}}function
setValue($value){if($value!==NULL&&!isset($this->flattenItems[(string)$value])){throw
new
Nette\InvalidArgumentException("Value '$value' is out of range of current items.");}$this->value=$value===NULL?NULL:key(array((string)$value=>NULL));return$this;}function
getValue(){return
isset($this->flattenItems[$this->value])?$this->value:NULL;}function
getRawValue(){return$this->value;}function
isFilled(){$value=$this->getValue();return$value!==NULL&&$value!==array();}function
setPrompt($prompt){if($prompt===TRUE){trigger_error(__METHOD__.'(TRUE) is deprecated; argument must be string.',E_USER_DEPRECATED);$prompt=reset($this->items);unset($this->flattenItems[key($this->items)],$this->items[key($this->items)]);}$this->prompt=$prompt;return$this;}final
function
getPrompt(){return$this->prompt;}function
setItems(array$items,$useKeys=TRUE){$flattenItems=array();foreach($items
as$key=>$value){$group=is_array($value);foreach($group?$value:array($key=>$value)as$gkey=>$gvalue){if(!$useKeys){if($group){unset($value[$gkey]);$value[(string)$gvalue]=$gvalue;}$gkey=(string)$gvalue;}if(isset($flattenItems[$gkey])){throw
new
Nette\InvalidArgumentException("Items contain duplication for key '$gkey'.");}$flattenItems[$gkey]=$gvalue;}if(!$useKeys){unset($items[$key]);$items[$group?$key:(string)$value]=$value;}}$this->items=$items;$this->flattenItems=$flattenItems;return$this;}final
function
getItems(){return$this->items;}function
getSelectedItem(){$value=$this->getValue();return$value===NULL?NULL:$this->flattenItems[$value];}function
setDisabled($value=TRUE){if(!is_array($value)){return
parent::setDisabled($value);}parent::setDisabled(FALSE);$this->disabled=array_fill_keys($value,TRUE);if(is_array($this->value)){$this->value=array_diff($this->value,$value);}elseif(isset($this->disabled[$this->value])){$this->value=NULL;}return$this;}function
getControl(){$selected=array_flip((array)$this->value);$select=parent::getControl()->setName('select');$option=Nette\Utils\Html::el('option');$items=$this->getItems();if($this->prompt!==FALSE){$items=array(''=>$this->prompt)+$items;}foreach($items
as$group=>$subitems){if(!is_array($subitems)){$subitems=array($group=>$subitems);$dest=$select;}else{$dest=$select->create('optgroup')->label($this->translate($group));}foreach($subitems
as$value=>$caption){$option=$caption
instanceof
Nette\Utils\Html?clone$caption:$option->setText($this->translate((string)$caption));$dest->add((string)$option->value($value)->selected(isset($selected[$value]))->disabled(is_array($this->disabled)?isset($this->disabled[$value]):FALSE));}}return$select;}function
validate(){parent::validate();if(!$this->isDisabled()&&$this->prompt===FALSE&&$this->getValue()===NULL){$this->addError(Nette\Forms\Validator::$messages[self::VALID]);}}}class
MultiSelectBox
extends
SelectBox{function
loadHttpData(){$this->value=array_keys(array_flip($this->getHttpData()));if(is_array($this->disabled)){$this->value=array_diff($this->value,array_keys($this->disabled));}}function
setValue($values){if(is_scalar($values)||$values===NULL){$values=(array)$values;}elseif(!is_array($values)){throw
new
Nette\InvalidArgumentException('Value must be array or NULL, '.gettype($values).' given.');}$flip=array();foreach($values
as$value){if(!is_scalar($value)&&!method_exists($value,'__toString')){throw
new
Nette\InvalidArgumentException('Values must be scalar, '.gettype($value).' given.');}$flip[(string)$value]=TRUE;}$values=array_keys($flip);if($diff=array_diff($values,array_keys($this->flattenItems))){throw
new
Nette\InvalidArgumentException("Values '".implode("', '",$diff)."' are out of range of current items.");}$this->value=$values;return$this;}function
getValue(){return
array_values(array_intersect($this->value,array_keys($this->flattenItems)));}function
getRawValue(){return$this->value;}function
getSelectedItem(){return
array_intersect_key($this->flattenItems,array_flip($this->value));}function
getHtmlName(){return
parent::getHtmlName().'[]';}function
getControl(){return
parent::getControl()->multiple(TRUE);}}class
RadioList
extends
BaseControl{protected$separator;protected$container;protected$items=array();function
__construct($label=NULL,array$items=NULL){parent::__construct($label);$this->container=Html::el();$this->separator=Html::el('br');if($items!==NULL){$this->setItems($items);}}function
loadHttpData(){$this->value=$this->getHttpData();if($this->value!==NULL){if(is_array($this->disabled)&&isset($this->disabled[$this->value])){$this->value=NULL;}else{$this->value=key(array($this->value=>NULL));}}}function
setValue($value){if($value!==NULL&&!isset($this->items[(string)$value])){throw
new
Nette\InvalidArgumentException("Value '$value' is out of range of current items.");}$this->value=$value===NULL?NULL:key(array((string)$value=>NULL));return$this;}function
getValue($raw=FALSE){if($raw){trigger_error(__METHOD__.'(TRUE) is deprecated; use getRawValue() instead.',E_USER_DEPRECATED);return$this->getRawValue();}return
isset($this->items[$this->value])?$this->value:NULL;}function
getRawValue(){return$this->value;}function
isFilled(){return$this->getValue()!==NULL;}function
setItems(array$items,$useKeys=TRUE){if(!$useKeys){$items=array_combine($items,$items);}$this->items=$items;return$this;}final
function
getItems(){return$this->items;}function
setDisabled($value=TRUE){if(!is_array($value)){return
parent::setDisabled($value);}parent::setDisabled(FALSE);$this->disabled=array_fill_keys($value,TRUE);if(isset($this->disabled[$this->value])){$this->value=NULL;}return$this;}final
function
getSeparatorPrototype(){return$this->separator;}final
function
getContainerPrototype(){return$this->container;}function
getControl($key=NULL){$selected=array_flip((array)$this->value);$input=parent::getControl()->type('radio');if($key!==NULL){return$input->addAttributes(array('type'=>'radio','id'=>$this->getHtmlId()."-$key",'checked'=>isset($selected[$key]),'value'=>$key));}$idBase=$input->id;$container=clone$this->container;$separator=(string)$this->separator;$label=parent::getLabel();foreach($this->items
as$value=>$caption){$input->id=$label->for=$idBase.'-'.$value;$input->checked(isset($selected[$value]))->disabled(is_array($this->disabled)?isset($this->disabled[$value]):$this->disabled)->value($value);$label->setText($this->translate($caption));$container->add($label->insert(0,$input).$separator);unset($input->attrs['data-nette-rules']);}return$container;}function
getLabel($caption=NULL,$key=NULL){if($key===NULL){$label=parent::getLabel($caption);$label->for=NULL;}else{$label=parent::getLabel($caption===NULL?$this->items[$key]:$caption);$label->for.='-'.$key;}return$label;}}abstract
class
TextBase
extends
BaseControl{protected$emptyValue='';protected$filters=array();function
setValue($value){if(!is_scalar($value)&&$value!==NULL&&!method_exists($value,'__toString')){throw
new
Nette\InvalidArgumentException('Value must be scalar or NULL, '.gettype($value).' given.');}$this->value=(string)$value;return$this;}function
getValue(){$value=(string)$this->value;if(!empty($this->control->maxlength)){$value=Nette\Utils\Strings::substring($value,0,$this->control->maxlength);}foreach($this->filters
as$filter){$value=(string)call_user_func($filter,$value);}return$value===$this->translate($this->emptyValue)?'':$value;}function
setEmptyValue($value){$this->emptyValue=(string)$value;return$this;}final
function
getEmptyValue(){return$this->emptyValue;}function
addFilter($filter){$this->filters[]=Nette\Utils\Callback::check($filter);return$this;}function
getControl(){$el=parent::getControl();if($this->emptyValue!==''){$el->attrs['data-nette-empty-value']=$this->translate($this->emptyValue);}if(isset($el->placeholder)){$el->placeholder=$this->translate($el->placeholder);}return$el;}function
addRule($operation,$message=NULL,$arg=NULL){if($operation===Form::FLOAT){$this->addFilter(function($s){return
str_replace(array(' ',','),array('','.'),$s);});}elseif($operation===Form::URL){$this->addFilter(function($s){return
Nette\Utils\Validators::isUrl('http://'.$s)?'http://'.$s:$s;});}elseif($operation===Form::LENGTH||$operation===Form::MAX_LENGTH){$tmp=is_array($arg)?$arg[1]:$arg;$this->control->maxlength=is_scalar($tmp)?$tmp:NULL;}return
parent::addRule($operation,$message,$arg);}}class
TextArea
extends
TextBase{function
getControl(){$value=$this->getValue();if($value===''){$value=$this->translate($this->emptyValue);}return
parent::getControl()->setName('textarea')->setText($value);}}class
TextInput
extends
TextBase{function
__construct($label=NULL,$maxLength=NULL){parent::__construct($label);$this->control->type='text';$this->control->maxlength=$maxLength;}function
loadHttpData(){$this->setValue($this->getHttpData(Nette\Forms\Form::DATA_LINE));}function
setType($type){$this->control->type=$type;return$this;}function
setPasswordMode($mode=TRUE){trigger_error(__METHOD__.'() is deprecated; use setType("password") instead.',E_USER_DEPRECATED);$this->control->type=$mode?'password':'text';return$this;}function
getControl(){$input=parent::getControl();foreach($this->getRules()as$rule){if($rule->isNegative||$rule->type!==Nette\Forms\Rule::VALIDATOR){}elseif($rule->operation===Nette\Forms\Form::RANGE&&$input->type!=='text'){$input->min=isset($rule->arg[0])&&is_scalar($rule->arg[0])?$rule->arg[0]:NULL;$input->max=isset($rule->arg[1])&&is_scalar($rule->arg[1])?$rule->arg[1]:NULL;}elseif($rule->operation===Nette\Forms\Form::PATTERN&&is_scalar($rule->arg)){$input->pattern=$rule->arg;}}if($input->type!=='password'){$input->value=$this->getValue()===''?$this->translate($this->emptyValue):$this->value;}return$input;}}use
Nette\Http\FileUpload;class
UploadControl
extends
BaseControl{function
__construct($label=NULL,$multiple=FALSE){parent::__construct($label);$this->control->type='file';$this->control->multiple=(bool)$multiple;}protected
function
attached($form){if($form
instanceof
Nette\Forms\Form){if($form->getMethod()!==Nette\Forms\Form::POST){throw
new
Nette\InvalidStateException('File upload requires method POST.');}$form->getElementPrototype()->enctype='multipart/form-data';}parent::attached($form);}function
loadHttpData(){$this->value=$this->getHttpData(Nette\Forms\Form::DATA_FILE);if($this->value===NULL){$this->value=new
FileUpload(NULL);}}function
getHtmlName(){return
parent::getHtmlName().($this->control->multiple?'[]':'');}function
setValue($value){return$this;}function
isFilled(){return$this->value
instanceof
FileUpload?$this->value->isOk():(bool)$this->value;}}}namespace Nette\Forms{use
Nette;use
Nette\Utils\Strings;use
Nette\Utils\Html;use
Nette\Localization\ITranslator;class
Helpers
extends
Nette\Object{static
function
extractHttpData(array$data,$htmlName,$type){$name=explode('[',str_replace(array('[]',']','.'),array('','','_'),$htmlName));$data=Nette\Utils\Arrays::get($data,$name,NULL);if(substr($htmlName,-2)==='[]'){$arr=array();foreach(is_array($data)?$data:array()as$v){$arr[]=$v=static::sanitize($type,$v);if($v===NULL){return
array();}}return$arr;}else{return
static::sanitize($type,$data);}}private
static
function
sanitize($type,$value){if($type===Form::DATA_TEXT){return
is_scalar($value)?Strings::normalizeNewLines($value):NULL;}elseif($type===Form::DATA_LINE){return
is_scalar($value)?Strings::trim(strtr($value,"\r\n",'  ')):NULL;}elseif($type===Form::DATA_FILE){return$value
instanceof
Nette\Http\FileUpload?$value:NULL;}else{throw
new
Nette\InvalidArgumentException('Unknown data type');}}static
function
generateHtmlName($id){$name=str_replace(Nette\ComponentModel\IComponent::NAME_SEPARATOR,'][',$id,$count);if($count){$name=substr_replace($name,'',strpos($name,']'),1).']';}if(is_numeric($name)||in_array($name,array('attributes','children','elements','focus','length','reset','style','submit','onsubmit'))){$name='_'.$name;}return$name;}static
function
exportRules(Rules$rules,$json=TRUE){$payload=array();foreach($rules
as$rule){if(!is_string($op=$rule->operation)){if(!Nette\Utils\Callback::isStatic($op)){continue;}$op=Nette\Utils\Callback::toString($op);}if($rule->type===Rule::VALIDATOR){$item=array('op'=>($rule->isNegative?'~':'').$op,'msg'=>Validator::formatMessage($rule,FALSE));}elseif($rule->type===Rule::CONDITION){$item=array('op'=>($rule->isNegative?'~':'').$op,'rules'=>static::exportRules($rule->subRules,FALSE),'control'=>$rule->control->getHtmlName());if($rule->subRules->getToggles()){$item['toggle']=$rule->subRules->getToggles();}}if(is_array($rule->arg)){foreach($rule->arg
as$key=>$value){$item['arg'][$key]=$value
instanceof
IControl?array('control'=>$value->getHtmlName()):$value;}}elseif($rule->arg!==NULL){$item['arg']=$rule->arg
instanceof
IControl?array('control'=>$rule->arg->getHtmlName()):$rule->arg;}$payload[]=$item;}return$json?($payload?Nette\Utils\Json::encode($payload):NULL):$payload;}static
function
createInputList(array$items,array$inputAttrs=NULL,array$labelAttrs=NULL,ITranslator$translator=NULL,$separator=NULL){list($inputAttrs,$inputTag)=self::prepareAttrs($inputAttrs,'input');list($labelAttrs,$labelTag)=self::prepareAttrs($labelAttrs,'label');$res='';$input=Html::el();$label=Html::el();foreach($items
as$value=>$caption){foreach($inputAttrs
as$k=>$v){$input->attrs[$k]=isset($v[$value])?$v[$value]:NULL;}foreach($labelAttrs
as$k=>$v){$label->attrs[$k]=isset($v[$value])?$v[$value]:NULL;}$input->value=$value;$res.=$labelTag.$label->attributes().'>'.$inputTag.$input->attributes().(Html::$xhtml?' />':'>').($caption
instanceof
Html?$caption:htmlspecialchars($translator?$translator->translate($caption):$caption)).'</label>'.$separator;}return$res;}static
function
createSelectBox(array$items,array$optionAttrs=NULL,ITranslator$translator=NULL){list($optionAttrs,$optionTag)=self::prepareAttrs($optionAttrs,'option');$option=Html::el();$res=$tmp='';foreach($items
as$group=>$subitems){if(is_array($subitems)){$res.=Html::el('optgroup')->label($translator?$translator->translate($group):$group)->startTag();$tmp='</optgroup>';}else{$subitems=array($group=>$subitems);}foreach($subitems
as$value=>$caption){$option->value=$value;foreach($optionAttrs
as$k=>$v){$option->attrs[$k]=isset($v[$value])?$v[$value]:NULL;}if($caption
instanceof
Html){$caption=clone$caption;$res.=$caption->setName('option')->addAttributes($option->attrs);}else{$res.=$optionTag.$option->attributes().'>'.htmlspecialchars($translator?$translator->translate($caption):$caption).'</option>';}}$res.=$tmp;$tmp='';}return
Html::el('select')->setHtml($res);}private
static
function
prepareAttrs($attrs,$name){$dynamic=array();foreach((array)$attrs
as$k=>$v){$parts=explode('|',$k);if(!isset($parts[1])){continue;}unset($attrs[$k],$attrs[$parts[0]]);if($parts[1]==='?'){$dynamic[$parts[0]]=array_fill_keys((array)$v,TRUE);}elseif(is_array($v)){$dynamic[$parts[0]]=$v;}else{$attrs[$parts[0]]=$v;}}return
array($dynamic,'<'.$name.Html::el(NULL,$attrs)->attributes());}}}namespace Nette\Forms\Rendering{use
Nette;use
Nette\Utils\Html;class
DefaultFormRenderer
extends
Nette\Object
implements
Nette\Forms\IFormRenderer{public$wrappers=array('form'=>array('container'=>NULL),'error'=>array('container'=>'ul class=error','item'=>'li'),'group'=>array('container'=>'fieldset','label'=>'legend','description'=>'p'),'controls'=>array('container'=>'table'),'pair'=>array('container'=>'tr','.required'=>'required','.optional'=>NULL,'.odd'=>NULL),'control'=>array('container'=>'td','.odd'=>NULL,'description'=>'small','requiredsuffix'=>'','errorcontainer'=>'span class=error','erroritem'=>'','.required'=>'required','.text'=>'text','.password'=>'text','.file'=>'text','.submit'=>'button','.image'=>'imagebutton','.button'=>'button'),'label'=>array('container'=>'th','suffix'=>NULL,'requiredsuffix'=>''),'hidden'=>array('container'=>'div'));protected$form;protected$counter;function
render(Nette\Forms\Form$form,$mode=NULL){if($this->form!==$form){$this->form=$form;}$s='';if(!$mode||$mode==='begin'){$s.=$this->renderBegin();}if(!$mode||$mode==='errors'){$s.=$this->renderErrors();}if(!$mode||$mode==='body'){$s.=$this->renderBody();}if(!$mode||$mode==='end'){$s.=$this->renderEnd();}return$s;}function
renderBegin(){$this->counter=0;foreach($this->form->getControls()as$control){$control->setOption('rendered',FALSE);}if(strcasecmp($this->form->getMethod(),'get')===0){$el=clone$this->form->getElementPrototype();$query=parse_url($el->action,PHP_URL_QUERY);$el->action=str_replace("?$query",'',$el->action);$s='';foreach(preg_split('#[;&]#',$query,NULL,PREG_SPLIT_NO_EMPTY)as$param){$parts=explode('=',$param,2);$name=urldecode($parts[0]);if(!isset($this->form[$name])){$s.=Html::el('input',array('type'=>'hidden','name'=>$name,'value'=>urldecode($parts[1])));}}return$el->startTag().($s?"\n\t".$this->getWrapper('hidden container')->setHtml($s):'');}else{return$this->form->getElementPrototype()->startTag();}}function
renderEnd(){$s='';foreach($this->form->getControls()as$control){if($control
instanceof
Nette\Forms\Controls\HiddenField&&!$control->getOption('rendered')){$s.=$control->getControl();}}if(iterator_count($this->form->getComponents(TRUE,'Nette\Forms\Controls\TextInput'))<2){$s.='<!--[if IE]><input type=IEbug disabled style="display:none"><![endif]-->';}if($s){$s=$this->getWrapper('hidden container')->setHtml($s)."\n";}return$s.$this->form->getElementPrototype()->endTag()."\n";}function
renderErrors(Nette\Forms\IControl$control=NULL){$errors=$control?$control->getErrors():$this->form->getErrors();if(!$errors){return;}$container=$this->getWrapper($control?'control errorcontainer':'error container');$item=$this->getWrapper($control?'control erroritem':'error item');foreach($errors
as$error){$item=clone$item;if($error
instanceof
Html){$item->add($error);}else{$item->setText($error);}$container->add($item);}return"\n".$container->render($control?1:0);}function
renderBody(){$s=$remains='';$defaultContainer=$this->getWrapper('group container');$translator=$this->form->getTranslator();foreach($this->form->getGroups()as$group){if(!$group->getControls()||!$group->getOption('visual')){continue;}$container=$group->getOption('container',$defaultContainer);$container=$container
instanceof
Html?clone$container:Html::el($container);$s.="\n".$container->startTag();$text=$group->getOption('label');if($text
instanceof
Html){$s.=$this->getWrapper('group label')->add($text);}elseif(is_string($text)){if($translator!==NULL){$text=$translator->translate($text);}$s.="\n".$this->getWrapper('group label')->setText($text)."\n";}$text=$group->getOption('description');if($text
instanceof
Html){$s.=$text;}elseif(is_string($text)){if($translator!==NULL){$text=$translator->translate($text);}$s.=$this->getWrapper('group description')->setText($text)."\n";}$s.=$this->renderControls($group);$remains=$container->endTag()."\n".$remains;if(!$group->getOption('embedNext')){$s.=$remains;$remains='';}}$s.=$remains.$this->renderControls($this->form);$container=$this->getWrapper('form container');$container->setHtml($s);return$container->render(0);}function
renderControls($parent){if(!($parent
instanceof
Nette\Forms\Container||$parent
instanceof
Nette\Forms\ControlGroup)){throw
new
Nette\InvalidArgumentException("Argument must be FormContainer or FormGroup instance.");}$container=$this->getWrapper('controls container');$buttons=NULL;foreach($parent->getControls()as$control){if($control->getOption('rendered')||$control
instanceof
Nette\Forms\Controls\HiddenField||$control->getForm(FALSE)!==$this->form){}elseif($control
instanceof
Nette\Forms\Controls\Button){$buttons[]=$control;}else{if($buttons){$container->add($this->renderPairMulti($buttons));$buttons=NULL;}$container->add($this->renderPair($control));}}if($buttons){$container->add($this->renderPairMulti($buttons));}$s='';if(count($container)){$s.="\n".$container."\n";}return$s;}function
renderPair(Nette\Forms\IControl$control){$pair=$this->getWrapper('pair container');$pair->add($this->renderLabel($control));$pair->add($this->renderControl($control));$pair->class($this->getValue($control->isRequired()?'pair .required':'pair .optional'),TRUE);$pair->class($control->getOption('class'),TRUE);if(++$this->counter
%
2){$pair->class($this->getValue('pair .odd'),TRUE);}$pair->id=$control->getOption('id');return$pair->render(0);}function
renderPairMulti(array$controls){$s=array();foreach($controls
as$control){if(!$control
instanceof
Nette\Forms\IControl){throw
new
Nette\InvalidArgumentException("Argument must be array of IFormControl instances.");}$description=$control->getOption('description');if($description
instanceof
Html){$description=' '.$control->getOption('description');}elseif(is_string($description)){$description=' '.$this->getWrapper('control description')->setText($control->translate($description));}else{$description='';}$el=$control->getControl();if($el
instanceof
Html&&$el->getName()==='input'){$el->class($this->getValue("control .$el->type"),TRUE);}$s[]=$el.$description;}$pair=$this->getWrapper('pair container');$pair->add($this->renderLabel($control));$pair->add($this->getWrapper('control container')->setHtml(implode(" ",$s)));return$pair->render(0);}function
renderLabel(Nette\Forms\IControl$control){if($control
instanceof
Nette\Forms\Controls\Checkbox){return$this->getWrapper('label container');}$suffix=$this->getValue('label suffix').($control->isRequired()?$this->getValue('label requiredsuffix'):'');$label=$control->getLabel();if($label
instanceof
Html){$label->add($suffix);if($control->isRequired()){$label->class($this->getValue('control .required'),TRUE);}}elseif($label!=NULL){$label.=$suffix;}return$this->getWrapper('label container')->setHtml($label);}function
renderControl(Nette\Forms\IControl$control){$body=$this->getWrapper('control container');if($this->counter
%
2){$body->class($this->getValue('control .odd'),TRUE);}$description=$control->getOption('description');if($description
instanceof
Html){$description=' '.$description;}elseif(is_string($description)){$description=' '.$this->getWrapper('control description')->setText($control->translate($description));}else{$description='';}if($control->isRequired()){$description=$this->getValue('control requiredsuffix').$description;}$el=$control->getControl();if($el
instanceof
Html&&$el->getName()==='input'){$el->class($this->getValue("control .$el->type"),TRUE);}if($control
instanceof
Nette\Forms\Controls\Checkbox){$el=$control->getLabel()->insert(0,$el);}return$body->setHtml($el.$description.$this->renderErrors($control));}protected
function
getWrapper($name){$data=$this->getValue($name);return$data
instanceof
Html?clone$data:Html::el($data);}protected
function
getValue($name){$name=explode(' ',$name);$data=&$this->wrappers[$name[0]][$name[1]];return$data;}}}namespace Nette\Forms{use
Nette;final
class
Rule
extends
Nette\Object{const
CONDITION=1;const
VALIDATOR=2;public$control;public$operation;public$arg;public$type;public$isNegative=FALSE;public$message;public$subRules;}final
class
Rules
extends
Nette\Object
implements\IteratorAggregate{public
static$defaultMessages;private$required;private$rules=array();private$parent;private$toggles=array();private$control;function
__construct(IControl$control){$this->control=$control;}function
setRequired($value=TRUE){if($value){$this->addRule(Form::REQUIRED,is_string($value)?$value:NULL);}else{$this->required=NULL;}return$this;}function
isRequired(){return(bool)$this->required;}function
addRule($operation,$message=NULL,$arg=NULL){$rule=new
Rule;$rule->control=$this->control;$rule->operation=$operation;$this->adjustOperation($rule);$rule->arg=$arg;$rule->type=Rule::VALIDATOR;$rule->message=$message;if($rule->operation===Form::REQUIRED){$this->required=$rule;}else{$this->rules[]=$rule;}return$this;}function
addCondition($operation,$arg=NULL){return$this->addConditionOn($this->control,$operation,$arg);}function
addConditionOn(IControl$control,$operation,$arg=NULL){$rule=new
Rule;$rule->control=$control;$rule->operation=$operation;$this->adjustOperation($rule);$rule->arg=$arg;$rule->type=Rule::CONDITION;$rule->subRules=new
static($this->control);$rule->subRules->parent=$this;$this->rules[]=$rule;return$rule->subRules;}function
elseCondition(){$rule=clone
end($this->parent->rules);$rule->isNegative=!$rule->isNegative;$rule->subRules=new
static($this->parent->control);$rule->subRules->parent=$this->parent;$this->parent->rules[]=$rule;return$rule->subRules;}function
endCondition(){return$this->parent;}function
toggle($id,$hide=TRUE){$this->toggles[$id]=$hide;return$this;}function
validate(){$errors=array();foreach($this
as$rule){$success=$this->validateRule($rule);if($rule->type===Rule::CONDITION&&$success){if($errors=$rule->subRules->validate()){break;}}elseif($rule->type===Rule::VALIDATOR&&!$success){$errors[]=Validator::formatMessage($rule,TRUE);break;}}return$errors;}static
function
validateRule(Rule$rule){$args=is_array($rule->arg)?$rule->arg:array($rule->arg);foreach($args
as&$val){$val=$val
instanceof
IControl?$val->getValue():$val;}return$rule->isNegative
xor
call_user_func(self::getCallback($rule),$rule->control,is_array($rule->arg)?$args:$args[0]);}final
function
getIterator(){$rules=$this->rules;if($this->required){array_unshift($rules,$this->required);}return
new\ArrayIterator($rules);}function
getToggles($actual=FALSE){$toggles=$this->toggles;foreach($actual?$this:array()as$rule){if($rule->type===Rule::CONDITION){$success=static::validateRule($rule);foreach($rule->subRules->getToggles(TRUE)as$id=>$hide){$toggles[$id]=empty($toggles[$id])?($success&&$hide):TRUE;}}}return$toggles;}private
function
adjustOperation($rule){if(is_string($rule->operation)&&ord($rule->operation[0])>127){$rule->isNegative=TRUE;$rule->operation=~$rule->operation;}if(!is_callable($this->getCallback($rule))){$operation=is_scalar($rule->operation)?" '$rule->operation'":'';throw
new
Nette\InvalidArgumentException("Unknown operation$operation for control '{$rule->control->name}'.");}}private
static
function
getCallback($rule){$op=$rule->operation;if(is_string($op)&&strncmp($op,':',1)===0){return'Nette\Forms\Validator::validate'.ltrim($op,':');}else{return$op;}}}Rules::$defaultMessages=&Validator::$messages;use
Nette\Utils\Strings;use
Nette\Utils\Validators;class
Validator
extends
Nette\Object{public
static$messages=array(Form::PROTECTION=>'Please submit this form again (security token has expired).',Form::EQUAL=>'Please enter %s.',Form::FILLED=>'Please complete mandatory field.',Form::MIN_LENGTH=>'Please enter a value of at least %d characters.',Form::MAX_LENGTH=>'Please enter a value no longer than %d characters.',Form::LENGTH=>'Please enter a value between %d and %d characters long.',Form::EMAIL=>'Please enter a valid email address.',Form::URL=>'Please enter a valid URL.',Form::INTEGER=>'Please enter a numeric value.',Form::FLOAT=>'Please enter a numeric value.',Form::RANGE=>'Please enter a value between %d and %d.',Form::MAX_FILE_SIZE=>'The size of the uploaded file can be up to %d bytes.',Form::IMAGE=>'The uploaded file must be image in format JPEG, GIF or PNG.',Nette\Forms\Controls\SelectBox::VALID=>'Please select a valid option.');static
function
formatMessage(Rule$rule,$withValue=TRUE){$message=$rule->message;if($message
instanceof
Nette\Utils\Html){return$message;}elseif($message===NULL&&is_string($rule->operation)&&isset(static::$messages[$rule->operation])){$message=static::$messages[$rule->operation];}elseif($message==NULL){trigger_error("Missing validation message for control '{$rule->control->name}'.",E_USER_WARNING);}if($translator=$rule->control->getForm()->getTranslator()){$message=$translator->translate($message,is_int($rule->arg)?$rule->arg:NULL);}$message=preg_replace_callback('#%(name|label|value|\d+\$[ds]|[ds])#',function($m)use($rule,$withValue){static$i=-1;switch($m[1]){case'name':return$rule->control->getName();case'label':return$rule->control->translate($rule->control->caption);case'value':return$withValue?$rule->control->getValue():$m[0];default:$args=is_array($rule->arg)?$rule->arg:array($rule->arg);$i=(int)$m[1]?$m[1]-1:$i+1;return
isset($args[$i])?($args[$i]instanceof
IControl?($withValue?$args[$i]->getValue():"%$i"):$args[$i]):'';}},$message);return$message;}static
function
validateEqual(IControl$control,$arg){$value=$control->getValue();foreach((is_array($value)?$value:array($value))as$val){foreach((is_array($arg)?$arg:array($arg))as$item){if((string)$val===(string)$item){return
TRUE;}}}return
FALSE;}static
function
validateFilled(IControl$control){return$control->isFilled();}static
function
validateValid(IControl$control){return!$control->getRules()->validate();}static
function
validateRange(IControl$control,$range){return
Validators::isInRange($control->getValue(),$range);}static
function
validateLength(IControl$control,$range){if(!is_array($range)){$range=array($range,$range);}$value=$control->getValue();return
Validators::isInRange(is_array($value)?count($value):Strings::length($value),$range);}static
function
validateMinLength(IControl$control,$length){return
static::validateLength($control,array($length,NULL));}static
function
validateMaxLength(IControl$control,$length){return
static::validateLength($control,array(NULL,$length));}static
function
validateSubmitted(Controls\SubmitButton$control){return$control->isSubmittedBy();}static
function
validateEmail(IControl$control){return
Validators::isEmail($control->getValue());}static
function
validateUrl(IControl$control){return
Validators::isUrl($control->getValue())||Validators::isUrl('http://'.$control->getValue());}static
function
validateRegexp(IControl$control,$regexp){trigger_error('Validator REGEXP is deprecated; use PATTERN instead (which is matched against the entire value and is case sensitive).',E_USER_DEPRECATED);return(bool)Strings::match($control->getValue(),$regexp);}static
function
validatePattern(IControl$control,$pattern){return(bool)Strings::match($control->getValue(),"\x01^($pattern)\\z\x01u");}static
function
validateInteger(IControl$control){return
Validators::isNumericInt($control->getValue());}static
function
validateFloat(IControl$control){return
Validators::isNumeric(str_replace(array(' ',','),array('','.'),$control->getValue()));}static
function
validateFileSize(Controls\UploadControl$control,$limit){foreach(static::toArray($control->getValue())as$file){if($file->getSize()>$limit||$file->getError()===UPLOAD_ERR_INI_SIZE){return
FALSE;}}return
TRUE;}static
function
validateMimeType(Controls\UploadControl$control,$mimeType){$mimeTypes=is_array($mimeType)?$mimeType:explode(',',$mimeType);foreach(static::toArray($control->getValue())as$file){$type=strtolower($file->getContentType());if(!in_array($type,$mimeTypes,TRUE)&&!in_array(preg_replace('#/.*#','/*',$type),$mimeTypes,TRUE)){return
FALSE;}}return
TRUE;}static
function
validateImage(Controls\UploadControl$control){foreach(static::toArray($control->getValue())as$file){if(!$file->isImage()){return
FALSE;}}return
TRUE;}private
static
function
toArray($value){return$value
instanceof
Nette\Http\FileUpload?array($value):(array)$value;}}}namespace Nette\Http{use
Nette;class
Context
extends
Nette\Object{private$request;private$response;function
__construct(IRequest$request,IResponse$response){$this->request=$request;$this->response=$response;}function
isModified($lastModified=NULL,$etag=NULL){if($lastModified){$this->response->setHeader('Last-Modified',$this->response->date($lastModified));}if($etag){$this->response->setHeader('ETag','"'.addslashes($etag).'"');}$ifNoneMatch=$this->request->getHeader('If-None-Match');if($ifNoneMatch==='*'){$match=TRUE;}elseif($ifNoneMatch!==NULL){$etag=$this->response->getHeader('ETag');if($etag==NULL||strpos(' '.strtr($ifNoneMatch,",\t",'  '),' '.$etag)===FALSE){return
TRUE;}else{$match=TRUE;}}$ifModifiedSince=$this->request->getHeader('If-Modified-Since');if($ifModifiedSince!==NULL){$lastModified=$this->response->getHeader('Last-Modified');if($lastModified!=NULL&&strtotime($lastModified)<=strtotime($ifModifiedSince)){$match=TRUE;}else{return
TRUE;}}if(empty($match)){return
TRUE;}$this->response->setCode(IResponse::S304_NOT_MODIFIED);return
FALSE;}function
getRequest(){return$this->request;}function
getResponse(){return$this->response;}}}namespace Nette\Http\Diagnostics{use
Nette;class
SessionPanel
extends
Nette\Object
implements
Nette\Diagnostics\IBarPanel{function
getTab(){ob_start();?>
<span title="Session #<?php echo
htmlspecialchars(session_id())?>"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAIvSURBVDjLpZNPiBJRHMffG6aZHcd1RNaYSspxSbFkWTpIh+iwVEpsFC1EYO2hQ9BlDx067L1b0KVDRQUa3jzWEughiDDDZRXbDtauU5QV205R6jo6at+3lNShKdgHH77zm9/f994MHQwGZCuLI1tctgVKpZJQLBYluxj6ty3M3V+alfvNG1Efzy03XGT9e3vu+rkD9/5rAiTPiGI/2RvZNrrSkmWL52ReGNw9f+3hzD8LIHmC9M2M4pHI2upbEqD18tdPnwmzOWJlpi/fmrAtcMrfnld5k+gvdeKTrcXT07FJxVovMHuMtsiUv3/xjzOoVCo3Lcs6DEi32xVAIBKJ0MzCY3My6BN1XSeqqpKnperGiamDUi6Xa3U6nTemaRLoGodEy+v1hlEsjBdXBEGg+Xz+2fgORazVamclSSLVavXMnjGHlM1m78iy7Gi321dDoVAYRQK0UCiMU0pfN5vNXShggH2gDud21gloeNahO6EfoSr4Iopi3TCMBS4aja40Go1vmOA9Ao7DsYgORx0ORxkadzqdS9AYdBn+uKIoTI9omsa28GTzO3iEBeMCHGyCIPQDdDd0lU0AaswG7L0X52QAHbs/uXkL6HD7twnKrIPL5Sqyjm63m00U93g8JdjHoC9QJIYCdfB8+CWmUqkuHKMI8rPThQahr8BeUEWwBt4BFZ33g0vJZPIQ/+s+kcCDDQSTn1c0BElD2HXj0Emv13tg+y/YrUQiITBNp9OdH302kDq15BFkAAAAAElFTkSuQmCC"
/>Session</span>
<?php
return
ob_get_clean();}function
getPanel(){ob_start();?>
<style class="nette-debug">#nette-debug .nette-SessionPanel .nette-inner{width:700px}#nette-debug .nette-SessionPanel .nette-inner table{width:100%}#nette-debug .nette-SessionPanel-parameters pre{background:#FDF5CE;padding:.4em .7em;border:1px dotted silver;overflow:auto}</style>

<div class="nette-SessionPanel">
	<h1>Session #<?php echo
htmlspecialchars(session_id())?> (Lifetime: <?php echo
htmlspecialchars(ini_get('session.cookie_lifetime'));?>)</h1>

	<div class="nette-inner">
		<?php if(empty($_SESSION)):?>
		<p><i>empty</i></p>
		<?php else:?>
		<table>
		<?php

foreach($_SESSION
as$k=>$v){if($k==='__NF'){$k='Nette Session';$v=isset($v['DATA'])?$v['DATA']:NULL;}echo'<tr><th>',htmlspecialchars($k),'</th><td>',Nette\Diagnostics\Dumper::toHtml($v),"</td></tr>\n";}?>
		</table>
		<?php endif?>
	</div>
</div>
<?php
return
ob_get_clean();}}}namespace Nette\Http{use
Nette;class
FileUpload
extends
Nette\Object{private$name;private$type;private$size;private$tmpName;private$error;function
__construct($value){foreach(array('name','type','size','tmp_name','error')as$key){if(!isset($value[$key])||!is_scalar($value[$key])){$this->error=UPLOAD_ERR_NO_FILE;return;}}$this->name=$value['name'];$this->size=$value['size'];$this->tmpName=$value['tmp_name'];$this->error=$value['error'];}function
getName(){return$this->name;}function
getSanitizedName(){return
trim(Nette\Utils\Strings::webalize($this->name,'.',FALSE),'.-');}function
getContentType(){if($this->isOk()&&$this->type===NULL){$this->type=Nette\Utils\MimeTypeDetector::fromFile($this->tmpName);}return$this->type;}function
getSize(){return$this->size;}function
getTemporaryFile(){return$this->tmpName;}function
__toString(){return$this->tmpName;}function
getError(){return$this->error;}function
isOk(){return$this->error===UPLOAD_ERR_OK;}function
move($dest){@mkdir(dirname($dest),0777,TRUE);@unlink($dest);if(!call_user_func(is_uploaded_file($this->tmpName)?'move_uploaded_file':'rename',$this->tmpName,$dest)){throw
new
Nette\InvalidStateException("Unable to move uploaded file '$this->tmpName' to '$dest'.");}chmod($dest,0666);$this->tmpName=$dest;return$this;}function
isImage(){return
in_array($this->getContentType(),array('image/gif','image/png','image/jpeg'),TRUE);}function
toImage(){return
Nette\Image::fromFile($this->tmpName);}function
getImageSize(){return$this->isOk()?@getimagesize($this->tmpName):NULL;}function
getContents(){return$this->isOk()?file_get_contents($this->tmpName):NULL;}}final
class
Helpers{static
function
ipMatch($ip,$mask){list($mask,$size)=explode('/',$mask.'/');$ipv4=strpos($ip,'.');$max=$ipv4?32:128;if(($ipv4
xor
strpos($mask,'.'))||$size<0||$size>$max){return
FALSE;}elseif($ipv4){$arr=array(ip2long($ip),ip2long($mask));}else{$arr=unpack('N*',inet_pton($ip).inet_pton($mask));$size=$size===''?0:$max-$size;}$bits=implode('',array_map(function($n){return
sprintf('%032b',$n);},$arr));return
substr($bits,0,$max-$size)===substr($bits,$max,$max-$size);}}class
Request
extends
Nette\Object
implements
IRequest{private$method;private$url;private$query;private$post;private$files;private$cookies;private$headers;private$remoteAddress;private$remoteHost;function
__construct(UrlScript$url,$query=NULL,$post=NULL,$files=NULL,$cookies=NULL,$headers=NULL,$method=NULL,$remoteAddress=NULL,$remoteHost=NULL){$this->url=$url;if($query===NULL){parse_str($url->query,$this->query);}else{$this->query=(array)$query;}$this->post=(array)$post;$this->files=(array)$files;$this->cookies=(array)$cookies;$this->headers=(array)$headers;$this->method=$method;$this->remoteAddress=$remoteAddress;$this->remoteHost=$remoteHost;}final
function
getUrl(){return$this->url;}final
function
getQuery($key=NULL,$default=NULL){if(func_num_args()===0){return$this->query;}elseif(isset($this->query[$key])){return$this->query[$key];}else{return$default;}}final
function
getPost($key=NULL,$default=NULL){if(func_num_args()===0){return$this->post;}elseif(isset($this->post[$key])){return$this->post[$key];}else{return$default;}}final
function
getFile($key){return
Nette\Utils\Arrays::get($this->files,func_get_args(),NULL);}final
function
getFiles(){return$this->files;}final
function
getCookie($key,$default=NULL){if(func_num_args()===0){return$this->cookies;}elseif(isset($this->cookies[$key])){return$this->cookies[$key];}else{return$default;}}final
function
getCookies(){return$this->cookies;}function
getMethod(){return$this->method;}function
isMethod($method){return
strcasecmp($this->method,$method)===0;}function
isPost(){return$this->isMethod('POST');}final
function
getHeader($header,$default=NULL){$header=strtolower($header);if(isset($this->headers[$header])){return$this->headers[$header];}else{return$default;}}function
getHeaders(){return$this->headers;}final
function
getReferer(){return
isset($this->headers['referer'])?new
Url($this->headers['referer']):NULL;}function
isSecured(){return$this->url->scheme==='https';}function
isAjax(){return$this->getHeader('X-Requested-With')==='XMLHttpRequest';}function
getRemoteAddress(){return$this->remoteAddress;}function
getRemoteHost(){if(!$this->remoteHost){$this->remoteHost=$this->remoteAddress?getHostByAddr($this->remoteAddress):NULL;}return$this->remoteHost;}function
detectLanguage(array$langs){$header=$this->getHeader('Accept-Language');if(!$header){return
NULL;}$s=strtolower($header);$s=strtr($s,'_','-');rsort($langs);preg_match_all('#('.implode('|',$langs).')(?:-[^\s,;=]+)?\s*(?:;\s*q=([0-9.]+))?#',$s,$matches);if(!$matches[0]){return
NULL;}$max=0;$lang=NULL;foreach($matches[1]as$key=>$value){$q=$matches[2][$key]===''?1.0:(float)$matches[2][$key];if($q>$max){$max=$q;$lang=$value;}}return$lang;}}use
Nette\Utils\Strings;class
RequestFactory
extends
Nette\Object{const
NONCHARS='#[^\x09\x0A\x0D\x20-\x7E\xA0-\x{10FFFF}]#u';public$urlFilters=array('path'=>array('#/{2,}#'=>'/'),'url'=>array());private$binary=FALSE;private$proxies=array();function
setBinary($binary=TRUE){$this->binary=(bool)$binary;return$this;}function
setProxy($proxy){$this->proxies=(array)$proxy;return$this;}function
createHttpRequest(){$url=new
UrlScript;$url->scheme=!empty($_SERVER['HTTPS'])&&strcasecmp($_SERVER['HTTPS'],'off')?'https':'http';$url->user=isset($_SERVER['PHP_AUTH_USER'])?$_SERVER['PHP_AUTH_USER']:'';$url->password=isset($_SERVER['PHP_AUTH_PW'])?$_SERVER['PHP_AUTH_PW']:'';if(isset($_SERVER['HTTP_HOST'])){$pair=explode(':',$_SERVER['HTTP_HOST']);}elseif(isset($_SERVER['SERVER_NAME'])){$pair=explode(':',$_SERVER['SERVER_NAME']);}else{$pair=array('');}$url->host=preg_match('#^[-._a-z0-9]+\z#',$pair[0])?$pair[0]:'';if(isset($pair[1])){$url->port=(int)$pair[1];}elseif(isset($_SERVER['SERVER_PORT'])){$url->port=(int)$_SERVER['SERVER_PORT'];}if(isset($_SERVER['REQUEST_URI'])){$requestUrl=$_SERVER['REQUEST_URI'];}elseif(isset($_SERVER['ORIG_PATH_INFO'])){$requestUrl=$_SERVER['ORIG_PATH_INFO'];if(isset($_SERVER['QUERY_STRING'])&&$_SERVER['QUERY_STRING']!=''){$requestUrl.='?'.$_SERVER['QUERY_STRING'];}}else{$requestUrl='';}$requestUrl=Strings::replace($requestUrl,$this->urlFilters['url']);$tmp=explode('?',$requestUrl,2);$url->path=Strings::replace($tmp[0],$this->urlFilters['path']);$url->query=isset($tmp[1])?$tmp[1]:'';$url->canonicalize();$url->path=Strings::fixEncoding($url->path);if(isset($_SERVER['SCRIPT_NAME'])){$script=$_SERVER['SCRIPT_NAME'];}elseif(isset($_SERVER['DOCUMENT_ROOT'],$_SERVER['SCRIPT_FILENAME'])&&strncmp($_SERVER['DOCUMENT_ROOT'],$_SERVER['SCRIPT_FILENAME'],strlen($_SERVER['DOCUMENT_ROOT']))===0){$script='/'.ltrim(strtr(substr($_SERVER['SCRIPT_FILENAME'],strlen($_SERVER['DOCUMENT_ROOT'])),'\\','/'),'/');}else{$script='/';}$path=strtolower($url->path).'/';$script=strtolower($script).'/';$max=min(strlen($path),strlen($script));for($i=0;$i<$max;$i++){if($path[$i]!==$script[$i]){break;}elseif($path[$i]==='/'){$url->scriptPath=substr($url->path,0,$i+1);}}$useFilter=(!in_array(ini_get('filter.default'),array('','unsafe_raw'))||ini_get('filter.default_flags'));parse_str($url->query,$query);if(!$query){$query=$useFilter?filter_input_array(INPUT_GET,FILTER_UNSAFE_RAW):(empty($_GET)?array():$_GET);}$post=$useFilter?filter_input_array(INPUT_POST,FILTER_UNSAFE_RAW):(empty($_POST)?array():$_POST);$cookies=$useFilter?filter_input_array(INPUT_COOKIE,FILTER_UNSAFE_RAW):(empty($_COOKIE)?array():$_COOKIE);$gpc=(bool)get_magic_quotes_gpc();if($gpc||!$this->binary){$list=array(&$query,&$post,&$cookies);while(list($key,$val)=each($list)){foreach($val
as$k=>$v){unset($list[$key][$k]);if($gpc){$k=stripslashes($k);}if(!$this->binary&&is_string($k)&&(preg_match(self::NONCHARS,$k)||preg_last_error())){}elseif(is_array($v)){$list[$key][$k]=$v;$list[]=&$list[$key][$k];}else{if($gpc&&!$useFilter){$v=stripSlashes($v);}if(!$this->binary&&(preg_match(self::NONCHARS,$v)||preg_last_error())){$v='';}$list[$key][$k]=$v;}}}unset($list,$key,$val,$k,$v);}$files=array();$list=array();if(!empty($_FILES)){foreach($_FILES
as$k=>$v){if(!$this->binary&&is_string($k)&&(preg_match(self::NONCHARS,$k)||preg_last_error())){continue;}$v['@']=&$files[$k];$list[]=$v;}}while(list(,$v)=each($list)){if(!isset($v['name'])){continue;}elseif(!is_array($v['name'])){if($gpc){$v['name']=stripSlashes($v['name']);}if(!$this->binary&&(preg_match(self::NONCHARS,$v['name'])||preg_last_error())){$v['name']='';}$v['@']=new
FileUpload($v);continue;}foreach($v['name']as$k=>$foo){if(!$this->binary&&is_string($k)&&(preg_match(self::NONCHARS,$k)||preg_last_error())){continue;}$list[]=array('name'=>$v['name'][$k],'type'=>$v['type'][$k],'size'=>$v['size'][$k],'tmp_name'=>$v['tmp_name'][$k],'error'=>$v['error'][$k],'@'=>&$v['@'][$k]);}}if(function_exists('apache_request_headers')){$headers=array_change_key_case(apache_request_headers(),CASE_LOWER);}else{$headers=array();foreach($_SERVER
as$k=>$v){if(strncmp($k,'HTTP_',5)==0){$k=substr($k,5);}elseif(strncmp($k,'CONTENT_',8)){continue;}$headers[strtr(strtolower($k),'_','-')]=$v;}}$remoteAddr=isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:NULL;$remoteHost=isset($_SERVER['REMOTE_HOST'])?$_SERVER['REMOTE_HOST']:NULL;foreach($this->proxies
as$proxy){if(Helpers::ipMatch($remoteAddr,$proxy)){if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){$remoteAddr=trim(current(explode(',',$_SERVER['HTTP_X_FORWARDED_FOR'])));}if(isset($_SERVER['HTTP_X_FORWARDED_HOST'])){$remoteHost=trim(current(explode(',',$_SERVER['HTTP_X_FORWARDED_HOST'])));}break;}}$method=isset($_SERVER['REQUEST_METHOD'])?$_SERVER['REQUEST_METHOD']:NULL;if($method==='POST'&&isset($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'])&&preg_match('#^[A-Z]+\z#',$_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'])){$method=$_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'];}return
new
Request($url,$query,$post,$files,$cookies,$headers,$method,$remoteAddr,$remoteHost);}}final
class
Response
extends
Nette\Object
implements
IResponse{private
static$fixIE=TRUE;public$cookieDomain='';public$cookiePath='/';public$cookieSecure=FALSE;public$cookieHttpOnly=TRUE;private$code=self::S200_OK;function
__construct(){if(PHP_VERSION_ID>=50400){$this->code=http_response_code();header_register_callback($this->removeDuplicateCookies);}}function
setCode($code){$code=(int)$code;static$allowed=array(200=>1,201=>1,202=>1,203=>1,204=>1,205=>1,206=>1,300=>1,301=>1,302=>1,303=>1,304=>1,307=>1,400=>1,401=>1,403=>1,404=>1,405=>1,406=>1,408=>1,410=>1,412=>1,415=>1,416=>1,500=>1,501=>1,503=>1,505=>1);if(!isset($allowed[$code])){throw
new
Nette\InvalidArgumentException("Bad HTTP response '$code'.");}elseif(headers_sent($file,$line)){throw
new
Nette\InvalidStateException("Cannot set HTTP code after HTTP headers have been sent".($file?" (output started at $file:$line).":"."));}else{$this->code=$code;$protocol=isset($_SERVER['SERVER_PROTOCOL'])?$_SERVER['SERVER_PROTOCOL']:'HTTP/1.1';header($protocol.' '.$code,TRUE,$code);}return$this;}function
getCode(){return$this->code;}function
setHeader($name,$value){if(headers_sent($file,$line)){throw
new
Nette\InvalidStateException("Cannot send header after HTTP headers have been sent".($file?" (output started at $file:$line).":"."));}if($value===NULL&&function_exists('header_remove')){header_remove($name);}elseif(strcasecmp($name,'Content-Length')===0&&ini_get('zlib.output_compression')){}else{header($name.': '.$value,TRUE,$this->code);}return$this;}function
addHeader($name,$value){if(headers_sent($file,$line)){throw
new
Nette\InvalidStateException("Cannot send header after HTTP headers have been sent".($file?" (output started at $file:$line).":"."));}header($name.': '.$value,FALSE,$this->code);return$this;}function
setContentType($type,$charset=NULL){$this->setHeader('Content-Type',$type.($charset?'; charset='.$charset:''));return$this;}function
redirect($url,$code=self::S302_FOUND){if(isset($_SERVER['SERVER_SOFTWARE'])&&preg_match('#^Microsoft-IIS/[1-5]#',$_SERVER['SERVER_SOFTWARE'])&&$this->getHeader('Set-Cookie')!==NULL){$this->setHeader('Refresh',"0;url=$url");return;}$this->setCode($code);$this->setHeader('Location',$url);echo"<h1>Redirect</h1>\n\n<p><a href=\"".htmlSpecialChars($url,ENT_IGNORE|ENT_QUOTES)."\">Please click here to continue</a>.</p>";}function
setExpiration($time){if(!$time){$this->setHeader('Cache-Control','s-maxage=0, max-age=0, must-revalidate');$this->setHeader('Expires','Mon, 23 Jan 1978 10:00:00 GMT');return$this;}$time=Nette\DateTime::from($time);$this->setHeader('Cache-Control','max-age='.($time->format('U')-time()));$this->setHeader('Expires',self::date($time));return$this;}function
isSent(){return
headers_sent();}function
getHeader($header,$default=NULL){$header.=':';$len=strlen($header);foreach(headers_list()as$item){if(strncasecmp($item,$header,$len)===0){return
ltrim(substr($item,$len));}}return$default;}function
getHeaders(){$headers=array();foreach(headers_list()as$header){$a=strpos($header,':');$headers[substr($header,0,$a)]=(string)substr($header,$a+2);}return$headers;}static
function
date($time=NULL){$time=Nette\DateTime::from($time);$time->setTimezone(new\DateTimeZone('GMT'));return$time->format('D, d M Y H:i:s \G\M\T');}function
__destruct(){if(self::$fixIE&&isset($_SERVER['HTTP_USER_AGENT'])&&strpos($_SERVER['HTTP_USER_AGENT'],'MSIE ')!==FALSE&&in_array($this->code,array(400,403,404,405,406,408,409,410,500,501,505),TRUE)&&$this->getHeader('Content-Type','text/html')==='text/html'){echo
Nette\Utils\Strings::random(2e3," \t\r\n");self::$fixIE=FALSE;}}function
setCookie($name,$value,$time,$path=NULL,$domain=NULL,$secure=NULL,$httpOnly=NULL){if(!headers_sent()&&ob_get_level()&&ob_get_length()){trigger_error("Possible problem: you are sending a cookie while already having some data in output buffer.  This may not work if the outputted data grows. Try starting the session earlier.",E_USER_NOTICE);}if(headers_sent($file,$line)){throw
new
Nette\InvalidStateException("Cannot set cookie after HTTP headers have been sent".($file?" (output started at $file:$line).":"."));}setcookie($name,$value,$time?Nette\DateTime::from($time)->format('U'):0,$path===NULL?$this->cookiePath:(string)$path,$domain===NULL?$this->cookieDomain:(string)$domain,$secure===NULL?$this->cookieSecure:(bool)$secure,$httpOnly===NULL?$this->cookieHttpOnly:(bool)$httpOnly);$this->removeDuplicateCookies();return$this;}function
removeDuplicateCookies(){if(headers_sent($file,$line)||ini_get('suhosin.cookie.encrypt')){return;}$flatten=array();foreach(headers_list()as$header){if(preg_match('#^Set-Cookie: .+?=#',$header,$m)){$flatten[$m[0]]=$header;header_remove('Set-Cookie');}}foreach(array_values($flatten)as$key=>$header){header($header,$key===0);}}function
deleteCookie($name,$path=NULL,$domain=NULL,$secure=NULL){$this->setCookie($name,FALSE,0,$path,$domain,$secure);}}class
Session
extends
Nette\Object{const
DEFAULT_FILE_LIFETIME=10800;private$regenerated;private
static$started;private$options=array('referer_check'=>'','use_cookies'=>1,'use_only_cookies'=>1,'use_trans_sid'=>0,'cookie_lifetime'=>0,'cookie_path'=>'/','cookie_domain'=>'','cookie_secure'=>FALSE,'cookie_httponly'=>TRUE,'gc_maxlifetime'=>self::DEFAULT_FILE_LIFETIME,'cache_limiter'=>NULL,'cache_expire'=>NULL,'hash_function'=>NULL,'hash_bits_per_character'=>NULL);private$request;private$response;function
__construct(IRequest$request,IResponse$response){$this->request=$request;$this->response=$response;}function
start(){if(self::$started){return;}$this->configure($this->options);$id=&$_COOKIE[session_name()];if(!is_string($id)||!preg_match('#^[0-9a-zA-Z,-]{22,128}\z#i',$id)){unset($_COOKIE[session_name()]);}set_error_handler(function($severity,$message)use(&$error){if(($severity&error_reporting())===$severity){$error=$message;restore_error_handler();}});session_start();if(!$error){restore_error_handler();}$this->response->removeDuplicateCookies();if($error){@session_write_close();throw
new
Nette\InvalidStateException("session_start(): $error");}self::$started=TRUE;$nf=&$_SESSION['__NF'];if(empty($nf['Time'])){$nf['Time']=time();$this->regenerated=TRUE;}$browserKey=$this->request->getCookie('nette-browser');if(!$browserKey){$browserKey=Nette\Utils\Strings::random();}$browserClosed=!isset($nf['B'])||$nf['B']!==$browserKey;$nf['B']=$browserKey;$this->sendCookie();if(isset($nf['META'])){$now=time();foreach($nf['META']as$section=>$metadata){if(is_array($metadata)){foreach($metadata
as$variable=>$value){if((!empty($value['B'])&&$browserClosed)||(!empty($value['T'])&&$now>$value['T'])||(isset($nf['DATA'][$section][$variable])&&is_object($nf['DATA'][$section][$variable])&&(isset($value['V'])?$value['V']:NULL)!=Nette\Reflection\ClassType::from($nf['DATA'][$section][$variable])->getAnnotation('serializationVersion'))){if($variable===''){unset($nf['META'][$section],$nf['DATA'][$section]);continue
2;}unset($nf['META'][$section][$variable],$nf['DATA'][$section][$variable]);}}}}}if($this->regenerated){$this->regenerated=FALSE;$this->regenerateId();}register_shutdown_function(array($this,'clean'));}function
isStarted(){return(bool)self::$started;}function
close(){if(self::$started){$this->clean();session_write_close();self::$started=FALSE;}}function
destroy(){if(!self::$started){throw
new
Nette\InvalidStateException('Session is not started.');}session_destroy();$_SESSION=NULL;self::$started=FALSE;if(!$this->response->isSent()){$params=session_get_cookie_params();$this->response->deleteCookie(session_name(),$params['path'],$params['domain'],$params['secure']);}}function
exists(){return
self::$started||$this->request->getCookie($this->getName())!==NULL;}function
regenerateId(){if(self::$started&&!$this->regenerated){if(headers_sent($file,$line)){throw
new
Nette\InvalidStateException("Cannot regenerate session ID after HTTP headers have been sent".($file?" (output started at $file:$line).":"."));}session_regenerate_id(TRUE);session_write_close();$backup=$_SESSION;session_start();$_SESSION=$backup;$this->response->removeDuplicateCookies();}$this->regenerated=TRUE;}function
getId(){return
session_id();}function
setName($name){if(!is_string($name)||!preg_match('#[^0-9.][^.]*\z#A',$name)){throw
new
Nette\InvalidArgumentException('Session name must be a string and cannot contain dot.');}session_name($name);return$this->setOptions(array('name'=>$name));}function
getName(){return
isset($this->options['name'])?$this->options['name']:session_name();}function
getSection($section,$class='Nette\Http\SessionSection'){return
new$class($this,$section);}function
hasSection($section){if($this->exists()&&!self::$started){$this->start();}return!empty($_SESSION['__NF']['DATA'][$section]);}function
getIterator(){if($this->exists()&&!self::$started){$this->start();}if(isset($_SESSION['__NF']['DATA'])){return
new\ArrayIterator(array_keys($_SESSION['__NF']['DATA']));}else{return
new\ArrayIterator;}}function
clean(){if(!self::$started||empty($_SESSION)){return;}$nf=&$_SESSION['__NF'];if(isset($nf['META'])&&is_array($nf['META'])){foreach($nf['META']as$name=>$foo){if(empty($nf['META'][$name])){unset($nf['META'][$name]);}}}if(empty($nf['META'])){unset($nf['META']);}if(empty($nf['DATA'])){unset($nf['DATA']);}}function
setOptions(array$options){if(self::$started){$this->configure($options);}$this->options=$options+$this->options;if(!empty($options['auto_start'])){$this->start();}return$this;}function
getOptions(){return$this->options;}private
function
configure(array$config){$special=array('cache_expire'=>1,'cache_limiter'=>1,'save_path'=>1,'name'=>1);foreach($config
as$key=>$value){if(!strncmp($key,'session.',8)){$key=substr($key,8);}$key=strtolower(preg_replace('#(.)(?=[A-Z])#','$1_',$key));if($value===NULL||ini_get("session.$key")==$value){continue;}elseif(strncmp($key,'cookie_',7)===0){if(!isset($cookie)){$cookie=session_get_cookie_params();}$cookie[substr($key,7)]=$value;}else{if(defined('SID')){throw
new
Nette\InvalidStateException("Unable to set 'session.$key' to value '$value' when session has been started".($this->started?".":" by session.auto_start or session_start()."));}if(isset($special[$key])){$key="session_$key";$key($value);}elseif(function_exists('ini_set')){ini_set("session.$key",$value);}else{throw
new
Nette\NotSupportedException('Required function ini_set() is disabled.');}}}if(isset($cookie)){session_set_cookie_params($cookie['lifetime'],$cookie['path'],$cookie['domain'],$cookie['secure'],$cookie['httponly']);if(self::$started){$this->sendCookie();}}}function
setExpiration($time){if(empty($time)){return$this->setOptions(array('gc_maxlifetime'=>self::DEFAULT_FILE_LIFETIME,'cookie_lifetime'=>0));}else{$time=Nette\DateTime::from($time)->format('U')-time();return$this->setOptions(array('gc_maxlifetime'=>$time,'cookie_lifetime'=>$time));}}function
setCookieParameters($path,$domain=NULL,$secure=NULL){return$this->setOptions(array('cookie_path'=>$path,'cookie_domain'=>$domain,'cookie_secure'=>$secure));}function
getCookieParameters(){return
session_get_cookie_params();}function
setSavePath($path){return$this->setOptions(array('save_path'=>$path));}function
setStorage(ISessionStorage$storage){if(self::$started){throw
new
Nette\InvalidStateException("Unable to set storage when session has been started.");}session_set_save_handler(array($storage,'open'),array($storage,'close'),array($storage,'read'),array($storage,'write'),array($storage,'remove'),array($storage,'clean'));}private
function
sendCookie(){if(!headers_sent()&&ob_get_level()&&ob_get_length()){trigger_error("Possible problem: you are starting session while already having some data in output buffer. This may not work if the outputted data grows. Try starting the session earlier.",E_USER_NOTICE);}$cookie=$this->getCookieParameters();$this->response->setCookie(session_name(),session_id(),$cookie['lifetime']?$cookie['lifetime']+time():0,$cookie['path'],$cookie['domain'],$cookie['secure'],$cookie['httponly'])->setCookie('nette-browser',$_SESSION['__NF']['B'],Response::BROWSER,$cookie['path'],$cookie['domain']);}}class
SessionSection
extends
Nette\Object
implements\IteratorAggregate,\ArrayAccess{private$session;private$name;private$data;private$meta=FALSE;public$warnOnUndefined=FALSE;function
__construct(Session$session,$name){if(!is_string($name)){throw
new
Nette\InvalidArgumentException("Session namespace must be a string, ".gettype($name)." given.");}$this->session=$session;$this->name=$name;}private
function
start(){if($this->meta===FALSE){$this->session->start();$this->data=&$_SESSION['__NF']['DATA'][$this->name];$this->meta=&$_SESSION['__NF']['META'][$this->name];}}function
getIterator(){$this->start();if(isset($this->data)){return
new\ArrayIterator($this->data);}else{return
new\ArrayIterator;}}function
__set($name,$value){$this->start();$this->data[$name]=$value;if(is_object($value)){$this->meta[$name]['V']=Nette\Reflection\ClassType::from($value)->getAnnotation('serializationVersion');}}function&__get($name){$this->start();if($this->warnOnUndefined&&!array_key_exists($name,$this->data)){trigger_error("The variable '$name' does not exist in session section",E_USER_NOTICE);}return$this->data[$name];}function
__isset($name){if($this->session->exists()){$this->start();}return
isset($this->data[$name]);}function
__unset($name){$this->start();unset($this->data[$name],$this->meta[$name]);}function
offsetSet($name,$value){$this->__set($name,$value);}function
offsetGet($name){return$this->__get($name);}function
offsetExists($name){return$this->__isset($name);}function
offsetUnset($name){$this->__unset($name);}function
setExpiration($time,$variables=NULL){$this->start();if(empty($time)){$time=NULL;$whenBrowserIsClosed=TRUE;}else{$time=Nette\DateTime::from($time)->format('U');$max=ini_get('session.gc_maxlifetime');if($time-time()>$max+3){trigger_error("The expiration time is greater than the session expiration $max seconds",E_USER_NOTICE);}$whenBrowserIsClosed=FALSE;}if($variables===NULL){$this->meta['']['T']=$time;$this->meta['']['B']=$whenBrowserIsClosed;}elseif(is_array($variables)){foreach($variables
as$variable){$this->meta[$variable]['T']=$time;$this->meta[$variable]['B']=$whenBrowserIsClosed;}}else{$this->meta[$variables]['T']=$time;$this->meta[$variables]['B']=$whenBrowserIsClosed;}return$this;}function
removeExpiration($variables=NULL){$this->start();if($variables===NULL){unset($this->meta['']['T'],$this->meta['']['B']);}elseif(is_array($variables)){foreach($variables
as$variable){unset($this->meta[$variable]['T'],$this->meta[$variable]['B']);}}else{unset($this->meta[$variables]['T'],$this->meta[$variable]['B']);}}function
remove(){$this->start();$this->data=NULL;$this->meta=NULL;}}class
Url
extends
Nette\Object{public
static$defaultPorts=array('http'=>80,'https'=>443,'ftp'=>21,'news'=>119,'nntp'=>119);private$scheme='';private$user='';private$pass='';private$host='';private$port=NULL;private$path='';private$query='';private$fragment='';function
__construct($url=NULL){if(is_string($url)){$parts=@parse_url($url);if($parts===FALSE){throw
new
Nette\InvalidArgumentException("Malformed or unsupported URI '$url'.");}foreach($parts
as$key=>$val){$this->$key=$val;}if(!$this->port&&isset(self::$defaultPorts[$this->scheme])){$this->port=self::$defaultPorts[$this->scheme];}if($this->path===''&&($this->scheme==='http'||$this->scheme==='https')){$this->path='/';}}elseif($url
instanceof
self){foreach($this
as$key=>$val){$this->$key=$url->$key;}}}function
setScheme($value){$this->scheme=(string)$value;return$this;}function
getScheme(){return$this->scheme;}function
setUser($value){$this->user=(string)$value;return$this;}function
getUser(){return$this->user;}function
setPassword($value){$this->pass=(string)$value;return$this;}function
getPassword(){return$this->pass;}function
setHost($value){$this->host=(string)$value;return$this;}function
getHost(){return$this->host;}function
setPort($value){$this->port=(int)$value;return$this;}function
getPort(){return$this->port;}function
setPath($value){$this->path=(string)$value;return$this;}function
getPath(){return$this->path;}function
setQuery($value){$this->query=(string)(is_array($value)?http_build_query($value,'','&'):$value);return$this;}function
appendQuery($value){$value=(string)(is_array($value)?http_build_query($value,'','&'):$value);$this->query.=($this->query===''||$value==='')?$value:'&'.$value;return$this;}function
getQuery(){return$this->query;}function
setFragment($value){$this->fragment=(string)$value;return$this;}function
getFragment(){return$this->fragment;}function
getAbsoluteUrl(){return$this->getHostUrl().$this->path.($this->query===''?'':'?'.$this->query).($this->fragment===''?'':'#'.$this->fragment);}function
getAuthority(){$authority=$this->host;if($this->port&&(!isset(self::$defaultPorts[$this->scheme])||$this->port!==self::$defaultPorts[$this->scheme])){$authority.=':'.$this->port;}if($this->user!==''&&$this->scheme!=='http'&&$this->scheme!=='https'){$authority=$this->user.($this->pass===''?'':':'.$this->pass).'@'.$authority;}return$authority;}function
getHostUrl(){return($this->scheme?$this->scheme.':':'').'//'.$this->getAuthority();}function
getBasePath(){$pos=strrpos($this->path,'/');return$pos===FALSE?'':substr($this->path,0,$pos+1);}function
getBaseUrl(){return$this->getHostUrl().$this->getBasePath();}function
getRelativeUrl(){return(string)substr($this->getAbsoluteUrl(),strlen($this->getBaseUrl()));}function
isEqual($url){$part=self::unescape(strtok($url,'?#'),'%/');if(strncmp($part,'//',2)===0){if($part!=='//'.$this->getAuthority().$this->path){return
FALSE;}}elseif(strncmp($part,'/',1)===0){if($part!==$this->path){return
FALSE;}}else{if($part!==$this->getHostUrl().$this->path){return
FALSE;}}$part=preg_split('#[&;]#',self::unescape(strtr((string)strtok('?#'),'+',' '),'%&;=+'));sort($part);$query=preg_split('#[&;]#',$this->query);sort($query);return$part===$query;}function
canonicalize(){$this->path=$this->path===''?'/':self::unescape($this->path,'%/');$this->host=strtolower(rawurldecode($this->host));$this->query=self::unescape(strtr($this->query,'+',' '),'%&;=+');return$this;}function
__toString(){return$this->getAbsoluteUrl();}static
function
unescape($s,$reserved='%;/?:@&=+$,'){preg_match_all('#(?<=%)[a-f0-9][a-f0-9]#i',$s,$matches,PREG_OFFSET_CAPTURE|PREG_SET_ORDER);foreach(array_reverse($matches)as$match){$ch=chr(hexdec($match[0][0]));if(strpos($reserved,$ch)===FALSE){$s=substr_replace($s,$ch,$match[0][1]-1,3);}}return$s;}}class
UrlScript
extends
Url{private$scriptPath='/';function
setScriptPath($value){$this->scriptPath=(string)$value;return$this;}function
getScriptPath(){return$this->scriptPath;}function
getBasePath(){$pos=strrpos($this->scriptPath,'/');return$pos===FALSE?'':substr($this->path,0,$pos+1);}function
getPathInfo(){return(string)substr($this->path,strlen($this->scriptPath));}}use
Nette\Security\IIdentity;class
UserStorage
extends
Nette\Object
implements
Nette\Security\IUserStorage{private$namespace='';private$sessionHandler;private$sessionSection;function
__construct(Session$sessionHandler){$this->sessionHandler=$sessionHandler;}function
setAuthenticated($state){$section=$this->getSessionSection(TRUE);$section->authenticated=(bool)$state;$this->sessionHandler->regenerateId();if($state){$section->reason=NULL;$section->authTime=time();}else{$section->reason=self::MANUAL;$section->authTime=NULL;}return$this;}function
isAuthenticated(){$session=$this->getSessionSection(FALSE);return$session&&$session->authenticated;}function
setIdentity(IIdentity$identity=NULL){$this->getSessionSection(TRUE)->identity=$identity;return$this;}function
getIdentity(){$session=$this->getSessionSection(FALSE);return$session?$session->identity:NULL;}function
setNamespace($namespace){if($this->namespace!==$namespace){$this->namespace=(string)$namespace;$this->sessionSection=NULL;}return$this;}function
getNamespace(){return$this->namespace;}function
setExpiration($time,$flags=0){$section=$this->getSessionSection(TRUE);if($time){$time=Nette\DateTime::from($time)->format('U');$section->expireTime=$time;$section->expireDelta=$time-time();}else{unset($section->expireTime,$section->expireDelta);}$section->expireIdentity=(bool)($flags&self::CLEAR_IDENTITY);$section->expireBrowser=(bool)($flags&self::BROWSER_CLOSED);$section->browserCheck=TRUE;$section->setExpiration(0,'browserCheck');$section->setExpiration($time,'foo');return$this;}function
getLogoutReason(){$session=$this->getSessionSection(FALSE);return$session?$session->reason:NULL;}protected
function
getSessionSection($need){if($this->sessionSection!==NULL){return$this->sessionSection;}if(!$need&&!$this->sessionHandler->exists()){return
NULL;}$this->sessionSection=$section=$this->sessionHandler->getSection('Nette.Http.UserStorage/'.$this->namespace);if(!$section->identity
instanceof
IIdentity||!is_bool($section->authenticated)){$section->remove();}if($section->authenticated&&$section->expireBrowser&&!$section->browserCheck){$section->reason=self::BROWSER_CLOSED;$section->authenticated=FALSE;if($section->expireIdentity){unset($section->identity);}}if($section->authenticated&&$section->expireDelta>0){if($section->expireTime<time()){$section->reason=self::INACTIVITY;$section->authenticated=FALSE;if($section->expireIdentity){unset($section->identity);}}$section->expireTime=time()+$section->expireDelta;}if(!$section->authenticated){unset($section->expireTime,$section->expireDelta,$section->expireIdentity,$section->expireBrowser,$section->browserCheck,$section->authTime);}return$this->sessionSection;}}}namespace Nette\Iterators{use
Nette;class
CachingIterator
extends\CachingIterator
implements\Countable{private$counter=0;function
__construct($iterator){if(is_array($iterator)||$iterator
instanceof\stdClass){$iterator=new\ArrayIterator($iterator);}elseif($iterator
instanceof\Traversable){if($iterator
instanceof\IteratorAggregate){$iterator=$iterator->getIterator();}elseif(!$iterator
instanceof\Iterator){$iterator=new\IteratorIterator($iterator);}}else{throw
new
Nette\InvalidArgumentException("Invalid argument passed to foreach resp. ".__CLASS__."; array or Traversable expected, ".(is_object($iterator)?get_class($iterator):gettype($iterator))." given.");}parent::__construct($iterator,0);}function
isFirst($width=NULL){return$this->counter===1||($width&&$this->counter!==0&&(($this->counter-1)%$width)===0);}function
isLast($width=NULL){return!$this->hasNext()||($width&&($this->counter
%$width)===0);}function
isEmpty(){return$this->counter===0;}function
isOdd(){return$this->counter
%
2===1;}function
isEven(){return$this->counter
%
2===0;}function
getCounter(){return$this->counter;}function
count(){$inner=$this->getInnerIterator();if($inner
instanceof\Countable){return$inner->count();}else{throw
new
Nette\NotSupportedException('Iterator is not countable.');}}function
next(){parent::next();if(parent::valid()){$this->counter++;}}function
rewind(){parent::rewind();$this->counter=parent::valid()?1:0;}function
getNextKey(){return$this->getInnerIterator()->key();}function
getNextValue(){return$this->getInnerIterator()->current();}function
__call($name,$args){return
Nette\ObjectMixin::call($this,$name,$args);}function&__get($name){return
Nette\ObjectMixin::get($this,$name);}function
__set($name,$value){return
Nette\ObjectMixin::set($this,$name,$value);}function
__isset($name){return
Nette\ObjectMixin::has($this,$name);}function
__unset($name){Nette\ObjectMixin::remove($this,$name);}}class
Filter
extends\FilterIterator{protected$callback;function
__construct(\Iterator$iterator,$callback){parent::__construct($iterator);$this->callback=Nette\Utils\Callback::check($callback);}function
accept(){return
call_user_func($this->callback,$this->current(),$this->key(),$this);}}class
Mapper
extends\IteratorIterator{private$callback;function
__construct(\Traversable$iterator,$callback){parent::__construct($iterator);$this->callback=Nette\Utils\Callback::check($callback);}function
current(){return
call_user_func($this->callback,parent::current(),parent::key());}}class
RecursiveFilter
extends
Filter
implements\RecursiveIterator{function
__construct(\RecursiveIterator$iterator,$callback){parent::__construct($iterator,$callback);}function
hasChildren(){return$this->getInnerIterator()->hasChildren();}function
getChildren(){return
new
static($this->getInnerIterator()->getChildren(),$this->callback);}}class
Recursor
extends\IteratorIterator
implements\RecursiveIterator,\Countable{function
hasChildren(){$obj=$this->current();return($obj
instanceof\IteratorAggregate&&$obj->getIterator()instanceof\RecursiveIterator)||$obj
instanceof\RecursiveIterator;}function
getChildren(){$obj=$this->current();return$obj
instanceof\IteratorAggregate?$obj->getIterator():$obj;}function
count(){return
iterator_count($this);}}}namespace Nette\Latte{use
Nette;use
Nette\Utils\Strings;class
Compiler
extends
Nette\Object{public$defaultContentType=self::CONTENT_HTML;private$tokens;private$output;private$position;private$macros;private$macroHandlers;private$htmlNode;private$macroNode;private$attrCodes=array();private$contentType;private$context;private$templateId;const
CONTENT_HTML='html',CONTENT_XHTML='xhtml',CONTENT_XML='xml',CONTENT_JS='js',CONTENT_CSS='css',CONTENT_ICAL='ical',CONTENT_TEXT='text';const
CONTEXT_COMMENT='comment',CONTEXT_SINGLE_QUOTED_ATTR="'",CONTEXT_DOUBLE_QUOTED_ATTR='"',CONTEXT_UNQUOTED_ATTR='=';function
__construct(){$this->macroHandlers=new\SplObjectStorage;}function
addMacro($name,IMacro$macro){$this->macros[$name][]=$macro;$this->macroHandlers->attach($macro);return$this;}function
compile(array$tokens){$this->templateId=Strings::random();$this->tokens=$tokens;$output='';$this->output=&$output;$this->htmlNode=$this->macroNode=NULL;$this->setContentType($this->defaultContentType);foreach($this->macroHandlers
as$handler){$handler->initialize($this);}try{foreach($tokens
as$this->position=>$token){$this->{"process$token->type"}($token);}}catch(CompileException$e){$e->sourceLine=$token->line;throw$e;}while($this->htmlNode){if(!empty($this->htmlNode->macroAttrs)){throw
new
CompileException("Missing end tag </{$this->htmlNode->name}> for macro-attribute ".Parser::N_PREFIX.implode(' and '.Parser::N_PREFIX,array_keys($this->htmlNode->macroAttrs)).".",0,$token->line);}$this->htmlNode=$this->htmlNode->parentNode;}$prologs=$epilogs='';foreach($this->macroHandlers
as$handler){$res=$handler->finalize();$handlerName=get_class($handler);$prologs.=empty($res[0])?'':"<?php\n// prolog $handlerName\n$res[0]\n?>";$epilogs=(empty($res[1])?'':"<?php\n// epilog $handlerName\n$res[1]\n?>").$epilogs;}$output=($prologs?$prologs."<?php\n//\n// main template\n//\n?>\n":'').$output.$epilogs;if($this->macroNode){throw
new
CompileException("There are unclosed macros.",0,$token->line);}$output=$this->expandTokens($output);return$output;}function
setContentType($type){$this->contentType=$type;$this->context=NULL;return$this;}function
getContentType(){return$this->contentType;}function
setContext($context,$sub=NULL){$this->context=array($context,$sub);return$this;}function
getContext(){return$this->context;}function
getTemplateId(){return$this->templateId;}function
getMacroNode(){return$this->macroNode;}function
getLine(){return$this->tokens?$this->tokens[$this->position]->line:NULL;}function
expandTokens($s){return
strtr($s,$this->attrCodes);}private
function
processText(Token$token){if(($this->context[0]===self::CONTEXT_SINGLE_QUOTED_ATTR||$this->context[0]===self::CONTEXT_DOUBLE_QUOTED_ATTR)&&$token->text===$this->context[0]){$this->setContext(self::CONTEXT_UNQUOTED_ATTR);}$this->output.=$token->text;}private
function
processMacroTag(Token$token){$isRightmost=!isset($this->tokens[$this->position+1])||substr($this->tokens[$this->position+1]->text,0,1)==="\n";if($token->name[0]==='/'){$this->closeMacro((string)substr($token->name,1),$token->value,$token->modifiers,$isRightmost);}else{$this->openMacro($token->name,$token->value,$token->modifiers,$isRightmost&&!$token->empty);if($token->empty){$this->closeMacro($token->name,NULL,NULL,$isRightmost);}}}private
function
processHtmlTagBegin(Token$token){if($token->closing){while($this->htmlNode){if(strcasecmp($this->htmlNode->name,$token->name)===0){break;}if($this->htmlNode->macroAttrs){throw
new
CompileException("Unexpected </$token->name>.",0,$token->line);}$this->htmlNode=$this->htmlNode->parentNode;}if(!$this->htmlNode){$this->htmlNode=new
HtmlNode($token->name);}$this->htmlNode->closing=TRUE;$this->htmlNode->offset=strlen($this->output);$this->setContext(NULL);}elseif($token->text==='<!--'){$this->setContext(self::CONTEXT_COMMENT);}else{$this->htmlNode=new
HtmlNode($token->name,$this->htmlNode);$this->htmlNode->isEmpty=in_array($this->contentType,array(self::CONTENT_HTML,self::CONTENT_XHTML))&&isset(Nette\Utils\Html::$emptyElements[strtolower($token->name)]);$this->htmlNode->offset=strlen($this->output);$this->setContext(self::CONTEXT_UNQUOTED_ATTR);}$this->output.=$token->text;}private
function
processHtmlTagEnd(Token$token){if($token->text==='-->'){$this->output.=$token->text;$this->setContext(NULL);return;}$htmlNode=$this->htmlNode;$isEmpty=!$htmlNode->closing&&(Strings::contains($token->text,'/')||$htmlNode->isEmpty);if($isEmpty&&in_array($this->contentType,array(self::CONTENT_HTML,self::CONTENT_XHTML))){$token->text=preg_replace('#^.*>#',$htmlNode->isEmpty?($this->contentType===self::CONTENT_XHTML?' />':'>'):"></$htmlNode->name>",$token->text);}if(empty($htmlNode->macroAttrs)){$this->output.=$token->text;}else{$code=substr($this->output,$htmlNode->offset).$token->text;$this->output=substr($this->output,0,$htmlNode->offset);$this->writeAttrsMacro($code);if($isEmpty){$htmlNode->closing=TRUE;$this->writeAttrsMacro('');}}if($isEmpty){$htmlNode->closing=TRUE;}if(!$htmlNode->closing&&(strcasecmp($htmlNode->name,'script')===0||strcasecmp($htmlNode->name,'style')===0)){$this->setContext(strcasecmp($htmlNode->name,'style')?self::CONTENT_JS:self::CONTENT_CSS);}else{$this->setContext(NULL);if($htmlNode->closing){$this->htmlNode=$this->htmlNode->parentNode;}}}private
function
processHtmlAttribute(Token$token){if(Strings::startsWith($token->name,Parser::N_PREFIX)){$name=substr($token->name,strlen(Parser::N_PREFIX));if(isset($this->htmlNode->macroAttrs[$name])){throw
new
CompileException("Found multiple macro-attributes $token->name.",0,$token->line);}elseif($this->macroNode&&$this->macroNode->htmlNode===$this->htmlNode){throw
new
CompileException("Macro-attributes must not appear inside macro; found $token->name inside {{$this->macroNode->name}}.",0,$token->line);}$this->htmlNode->macroAttrs[$name]=$token->value;}else{$this->htmlNode->attrs[$token->name]=TRUE;$this->output.=$token->text;if($token->value){$context=NULL;if(strncasecmp($token->name,'on',2)===0){$context=self::CONTENT_JS;}elseif($token->name==='style'){$context=self::CONTENT_CSS;}$this->setContext($token->value,$context);}}}private
function
processComment(Token$token){$isLeftmost=trim(substr($this->output,strrpos("\n$this->output","\n")))==='';if(!$isLeftmost){$this->output.=substr($token->text,strlen(rtrim($token->text,"\n")));}}function
openMacro($name,$args=NULL,$modifiers=NULL,$isRightmost=FALSE,$nPrefix=NULL){$node=$this->expandMacro($name,$args,$modifiers,$nPrefix);if($node->isEmpty){$this->writeCode($node->openingCode,$this->output,$isRightmost);}else{$this->macroNode=$node;$node->saved=array(&$this->output,$isRightmost);$this->output=&$node->content;}return$node;}function
closeMacro($name,$args=NULL,$modifiers=NULL,$isRightmost=FALSE){$node=$this->macroNode;if(!$node||($node->name!==$name&&''!==$name)||$modifiers||($args&&$node->args&&!Strings::startsWith("$node->args ","$args "))){$name.=$args?' ':'';throw
new
CompileException("Unexpected macro {/{$name}{$args}{$modifiers}}".($node?", expecting {/$node->name}".($args&&$node->args?" or eventually {/$node->name $node->args}":''):''));}$this->macroNode=$node->parentNode;if(!$node->args){$node->setArgs($args);}$isLeftmost=$node->content?trim(substr($this->output,strrpos("\n$this->output","\n")))==='':FALSE;$node->closing=TRUE;$node->macro->nodeClosed($node);$this->output=&$node->saved[0];$this->writeCode($node->openingCode,$this->output,$node->saved[1]);$this->writeCode($node->closingCode,$node->content,$isRightmost,$isLeftmost);$this->output.=$node->content;return$node;}private
function
writeCode($code,&$output,$isRightmost,$isLeftmost=NULL){if($isRightmost){$leftOfs=strrpos("\n$output","\n");$isLeftmost=$isLeftmost===NULL?trim(substr($output,$leftOfs))==='':$isLeftmost;if($isLeftmost&&substr($code,0,11)!=='<?php echo '){$output=substr($output,0,$leftOfs);}elseif(substr($code,-2)==='?>'){$code.="\n";}}$output.=$code;}function
writeAttrsMacro($code){$attrs=$this->htmlNode->macroAttrs;$left=$right=array();$attrCode='';foreach($this->macros
as$name=>$foo){$attrName=MacroNode::PREFIX_INNER."-$name";if(isset($attrs[$attrName])){if($this->htmlNode->closing){$left[]=array(TRUE,$name,'',MacroNode::PREFIX_INNER);}else{array_unshift($right,array(FALSE,$name,$attrs[$attrName],MacroNode::PREFIX_INNER));}unset($attrs[$attrName]);}}foreach(array_reverse($this->macros)as$name=>$foo){$attrName=MacroNode::PREFIX_TAG."-$name";if(isset($attrs[$attrName])){$left[]=array(FALSE,$name,$attrs[$attrName],MacroNode::PREFIX_TAG);array_unshift($right,array(TRUE,$name,'',MacroNode::PREFIX_TAG));unset($attrs[$attrName]);}}foreach($this->macros
as$name=>$foo){if(isset($attrs[$name])){if($this->htmlNode->closing){$right[]=array(TRUE,$name,'',MacroNode::PREFIX_NONE);}else{array_unshift($left,array(FALSE,$name,$attrs[$name],MacroNode::PREFIX_NONE));}unset($attrs[$name]);}}if($attrs){throw
new
CompileException("Unknown macro-attribute ".Parser::N_PREFIX.implode(' and '.Parser::N_PREFIX,array_keys($attrs)));}if(!$this->htmlNode->closing){$this->htmlNode->attrCode=&$this->attrCodes[$uniq=' n:'.Nette\Utils\Strings::random()];$code=substr_replace($code,$uniq,strrpos($code,'/>')?:strrpos($code,'>'),0);}foreach($left
as$item){$node=$item[0]?$this->closeMacro($item[1],$item[2]):$this->openMacro($item[1],$item[2],NULL,NULL,$item[3]);if($node->closing||$node->isEmpty){$this->htmlNode->attrCode.=$node->attrCode;if($node->isEmpty){unset($this->htmlNode->macroAttrs[$node->name]);}}}$this->output.=$code;foreach($right
as$item){$node=$item[0]?$this->closeMacro($item[1],$item[2]):$this->openMacro($item[1],$item[2],NULL,NULL,$item[3]);if($node->closing){$this->htmlNode->attrCode.=$node->attrCode;}}if($right&&substr($this->output,-2)==='?>'){$this->output.="\n";}}function
expandMacro($name,$args,$modifiers=NULL,$nPrefix=NULL){if(empty($this->macros[$name])){$cdata=$this->htmlNode&&in_array(strtolower($this->htmlNode->name),array('script','style'));throw
new
CompileException("Unknown macro {{$name}}".($cdata?" (in JavaScript or CSS, try to put a space after bracket.)":''));}$modifiers=preg_replace('#\|noescape\s?(?=\||\z)#i','',$modifiers,-1,$noescape);if(!$noescape&&strpbrk($name,'=~%^&_')){$modifiers.='|escape';}foreach(array_reverse($this->macros[$name])as$macro){$node=new
MacroNode($macro,$name,$args,$modifiers,$this->macroNode,$this->htmlNode,$nPrefix);if($macro->nodeOpened($node)!==FALSE){return$node;}}throw
new
CompileException("Unhandled macro {{$name}}");}}class
Engine
extends
Nette\Object{private$parser;private$compiler;function
__construct(){$this->parser=new
Parser;$this->compiler=new
Compiler;$this->compiler->defaultContentType=Compiler::CONTENT_HTML;Macros\CoreMacros::install($this->compiler);$this->compiler->addMacro('cache',new
Macros\CacheMacro($this->compiler));Macros\UIMacros::install($this->compiler);Macros\FormMacros::install($this->compiler);}function
__invoke($s){return$this->compiler->compile($this->parser->parse($s));}function
getParser(){return$this->parser;}function
getCompiler(){return$this->compiler;}}}namespace Nette\Templating{use
Nette;class
FilterException
extends
Nette\InvalidStateException{public$sourceFile;public$sourceLine;function
__construct($message,$code=0,$sourceLine=0){$this->sourceLine=(int)$sourceLine;parent::__construct($message,$code);}function
setSourceFile($file){$this->sourceFile=(string)$file;$this->message=rtrim($this->message,'.')." in ".str_replace(dirname(dirname($file)),'...',$file).($this->sourceLine?":$this->sourceLine":'');}}}namespace Nette\Latte{use
Nette;class
CompileException
extends
Nette\Templating\FilterException{}class_alias('Nette\Latte\CompileException','Nette\Latte\ParseException');class
HtmlNode
extends
Nette\Object{public$name;public$isEmpty=FALSE;public$attrs=array();public$macroAttrs=array();public$closing=FALSE;public$parentNode;public$attrCode;public$offset;function
__construct($name,self$parentNode=NULL){$this->name=$name;$this->parentNode=$parentNode;}}class
MacroNode
extends
Nette\Object{const
PREFIX_INNER='inner',PREFIX_TAG='tag',PREFIX_NONE='none';public$macro;public$name;public$isEmpty=FALSE;public$args;public$modifiers;public$closing=FALSE;public$tokenizer;public$parentNode;public$openingCode;public$closingCode;public$attrCode;public$content;public$data;public$htmlNode;public$prefix;public$saved;function
__construct(IMacro$macro,$name,$args=NULL,$modifiers=NULL,self$parentNode=NULL,HtmlNode$htmlNode=NULL,$prefix=NULL){$this->macro=$macro;$this->name=(string)$name;$this->modifiers=(string)$modifiers;$this->parentNode=$parentNode;$this->htmlNode=$htmlNode;$this->prefix=$prefix;$this->data=new\stdClass;$this->setArgs($args);}function
setArgs($args){$this->args=(string)$args;$this->tokenizer=new
MacroTokens($this->args);}}}namespace Nette\Latte\Macros{use
Nette;use
Nette\Latte;class
CacheMacro
extends
Nette\Object
implements
Latte\IMacro{private$used;function
initialize(){$this->used=FALSE;}function
finalize(){if($this->used){return
array('Nette\Latte\Macros\CacheMacro::initRuntime($template, $_g);');}}function
nodeOpened(Latte\MacroNode$node){$this->used=TRUE;$node->isEmpty=FALSE;$node->openingCode=Latte\PhpWriter::using($node)->write('<?php if (Nette\Latte\Macros\CacheMacro::createCache($netteCacheStorage, %var, $_g->caches, %node.array?)) { ?>',Nette\Utils\Strings::random());}function
nodeClosed(Latte\MacroNode$node){$node->closingCode='<?php $_l->tmp = array_pop($_g->caches); if (!$_l->tmp instanceof stdClass) $_l->tmp->end(); } ?>';}static
function
initRuntime(Nette\Templating\FileTemplate$template,\stdClass$global){if(!empty($global->caches)){end($global->caches)->dependencies[Nette\Caching\Cache::FILES][]=$template->getFile();}}static
function
createCache(Nette\Caching\IStorage$cacheStorage,$key,&$parents,array$args=NULL){if($args){if(array_key_exists('if',$args)&&!$args['if']){return$parents[]=new\stdClass;}$key=array_merge(array($key),array_intersect_key($args,range(0,count($args))));}if($parents){end($parents)->dependencies[Nette\Caching\Cache::ITEMS][]=$key;}$cache=new
Nette\Caching\Cache($cacheStorage,'Nette.Templating.Cache');if($helper=$cache->start($key)){if(isset($args['expire'])){$args['expiration']=$args['expire'];}$helper->dependencies=array(Nette\Caching\Cache::TAGS=>isset($args['tags'])?$args['tags']:NULL,Nette\Caching\Cache::EXPIRATION=>isset($args['expiration'])?$args['expiration']:'+ 7 days');$parents[]=$helper;}return$helper;}}use
Nette\Latte\MacroNode;class
MacroSet
extends
Nette\Object
implements
Latte\IMacro{private$compiler;private$macros;function
__construct(Latte\Compiler$compiler){$this->compiler=$compiler;}function
addMacro($name,$begin,$end=NULL,$attr=NULL){$this->macros[$name]=array($begin,$end,$attr);$this->compiler->addMacro($name,$this);return$this;}static
function
install(Latte\Compiler$compiler){return
new
static($compiler);}function
initialize(){}function
finalize(){}function
nodeOpened(MacroNode$node){if($this->macros[$node->name][2]&&$node->prefix){$node->isEmpty=TRUE;$this->compiler->setContext(Latte\Compiler::CONTEXT_DOUBLE_QUOTED_ATTR);$res=$this->compile($node,$this->macros[$node->name][2]);$this->compiler->setContext(NULL);if(!$node->attrCode){$node->attrCode="<?php $res ?>";}}else{$node->isEmpty=!isset($this->macros[$node->name][1]);$res=$this->compile($node,$this->macros[$node->name][0]);if(!$node->openingCode){$node->openingCode="<?php $res ?>";}}return$res!==FALSE;}function
nodeClosed(MacroNode$node){$res=$this->compile($node,$this->macros[$node->name][1]);if(!$node->closingCode){$node->closingCode="<?php $res ?>";}}private
function
compile(MacroNode$node,$def){$node->tokenizer->reset();$writer=Latte\PhpWriter::using($node,$this->compiler);if(is_string($def)){return$writer->write($def);}else{return
Nette\Utils\Callback::invoke($def,$node,$writer);}}function
getCompiler(){return$this->compiler;}}use
Nette\Latte\CompileException;use
Nette\Latte\PhpWriter;class
CoreMacros
extends
MacroSet{static
function
install(Latte\Compiler$compiler){$me=new
static($compiler);$me->addMacro('if',array($me,'macroIf'),array($me,'macroEndIf'));$me->addMacro('elseif','elseif (%node.args):');$me->addMacro('else',array($me,'macroElse'));$me->addMacro('ifset','if (isset(%node.args)):','endif');$me->addMacro('elseifset','elseif (isset(%node.args)):');$me->addMacro('ifcontent',array($me,'macroIfContent'),array($me,'macroEndIfContent'));$me->addMacro('foreach','',array($me,'macroEndForeach'));$me->addMacro('for','for (%node.args):','endfor');$me->addMacro('while','while (%node.args):','endwhile');$me->addMacro('continueIf',array($me,'macroBreakContinueIf'));$me->addMacro('breakIf',array($me,'macroBreakContinueIf'));$me->addMacro('first','if ($iterator->isFirst(%node.args)):','endif');$me->addMacro('last','if ($iterator->isLast(%node.args)):','endif');$me->addMacro('sep','if (!$iterator->isLast(%node.args)):','endif');$me->addMacro('var',array($me,'macroVar'));$me->addMacro('assign',array($me,'macroVar'));$me->addMacro('default',array($me,'macroVar'));$me->addMacro('dump',array($me,'macroDump'));$me->addMacro('debugbreak',array($me,'macroDebugbreak'));$me->addMacro('l','?>{<?php');$me->addMacro('r','?>}<?php');$me->addMacro('_',array($me,'macroTranslate'),array($me,'macroTranslate'));$me->addMacro('=',array($me,'macroExpr'));$me->addMacro('?',array($me,'macroExpr'));$me->addMacro('capture',array($me,'macroCapture'),array($me,'macroCaptureEnd'));$me->addMacro('include',array($me,'macroInclude'));$me->addMacro('use',array($me,'macroUse'));$me->addMacro('class',NULL,NULL,array($me,'macroClass'));$me->addMacro('attr',array($me,'macroOldAttr'),'',array($me,'macroAttr'));$me->addMacro('href',NULL);}function
finalize(){return
array('list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, '.var_export($this->getCompiler()->getTemplateId(),TRUE).')');}function
macroIf(MacroNode$node,PhpWriter$writer){if($node->data->capture=($node->args==='')){return'ob_start()';}if($node->prefix===$node::PREFIX_TAG){return$writer->write($node->htmlNode->closing?'if (array_pop($_l->ifs)):':'if ($_l->ifs[] = (%node.args)):');}return$writer->write('if (%node.args):');}function
macroEndIf(MacroNode$node,PhpWriter$writer){if($node->data->capture){if($node->args===''){throw
new
CompileException('Missing condition in {if} macro.');}return$writer->write('if (%node.args) '.(isset($node->data->else)?'{ ob_end_clean(); ob_end_flush(); }':'ob_end_flush();').' else '.(isset($node->data->else)?'{ $_else = ob_get_contents(); ob_end_clean(); ob_end_clean(); echo $_else; }':'ob_end_clean();'));}return'endif';}function
macroElse(MacroNode$node,PhpWriter$writer){$ifNode=$node->parentNode;if($ifNode&&$ifNode->name==='if'&&$ifNode->data->capture){if(isset($ifNode->data->else)){throw
new
CompileException("Macro {if} supports only one {else}.");}$ifNode->data->else=TRUE;return'ob_start()';}return'else:';}function
macroIfContent(MacroNode$node,PhpWriter$writer){if(!$node->htmlNode){throw
new
CompileException("Unknown macro {{$node->name}}, use n:{$node->name} attribute.");}elseif($node->prefix!==MacroNode::PREFIX_NONE){throw
new
CompileException("Unknown attribute n:{$node->prefix}-{$node->name}, use n:{$node->name} attribute.");}return$writer->write('ob_start()');}function
macroEndIfContent(MacroNode$node,PhpWriter$writer){preg_match('#(^.*?>)(.*)(<.*\z)#s',$node->content,$parts);$node->content=$parts[1].'<?php ob_start() ?>'.$parts[2].'<?php $_ifcontent = ob_get_length(); ob_end_flush() ?>'.$parts[3];return'$_ifcontent ? ob_end_flush() : ob_end_clean()';}function
macroTranslate(MacroNode$node,PhpWriter$writer){if($node->closing){return$writer->write('echo %modify($template->translate(ob_get_clean()))');}elseif($node->isEmpty=($node->args!=='')){return$writer->write('echo %modify($template->translate(%node.args))');}else{return'ob_start()';}}function
macroInclude(MacroNode$node,PhpWriter$writer){$code=$writer->write('Nette\Latte\Macros\CoreMacros::includeTemplate(%node.word, %node.array? + $template->getParameters(), $_l->templates[%var])',$this->getCompiler()->getTemplateId());if($node->modifiers){return$writer->write('echo %modify(%raw->__toString(TRUE))',$code);}else{return$code.'->render()';}}function
macroUse(MacroNode$node,PhpWriter$writer){Nette\Utils\Callback::invoke(array($node->tokenizer->fetchWord(),'install'),$this->getCompiler())->initialize();}function
macroCapture(MacroNode$node,PhpWriter$writer){$variable=$node->tokenizer->fetchWord();if(substr($variable,0,1)!=='$'){throw
new
CompileException("Invalid capture block variable '$variable'");}$node->data->variable=$variable;return'ob_start()';}function
macroCaptureEnd(MacroNode$node,PhpWriter$writer){return$node->data->variable.$writer->write(" = %modify(ob_get_clean())");}function
macroEndForeach(MacroNode$node,PhpWriter$writer){if(preg_match('#\W(\$iterator|include|require|get_defined_vars)\W#',$this->getCompiler()->expandTokens($node->content))){$node->openingCode='<?php $iterations = 0; foreach ($iterator = $_l->its[] = new Nette\Iterators\CachingIterator('.preg_replace('#(.*)\s+as\s+#i','$1) as ',$writer->formatArgs(),1).'): ?>';$node->closingCode='<?php $iterations++; endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>';}else{$node->openingCode='<?php $iterations = 0; foreach ('.$writer->formatArgs().'): ?>';$node->closingCode='<?php $iterations++; endforeach ?>';}}function
macroBreakContinueIf(MacroNode$node,PhpWriter$writer){$cmd=str_replace('If','',$node->name);if($node->parentNode&&$node->parentNode->prefix===$node::PREFIX_NONE){return$writer->write("if (%node.args) { echo \"</{$node->parentNode->htmlNode->name}>\\n\"; $cmd; }");}return$writer->write("if (%node.args) $cmd");}function
macroClass(MacroNode$node,PhpWriter$writer){return$writer->write('if ($_l->tmp = array_filter(%node.array)) echo \' class="\' . %escape(implode(" ", array_unique($_l->tmp))) . \'"\'');}function
macroAttr(MacroNode$node,PhpWriter$writer){return$writer->write('echo Nette\Utils\Html::el(NULL, %node.array)->attributes()');}function
macroOldAttr(MacroNode$node){trigger_error('Macro {attr} is deprecated; use n:attr="..." instead.',E_USER_DEPRECATED);return
Nette\Utils\Strings::replace($node->args.' ','#\)\s+#',')->');}function
macroDump(MacroNode$node,PhpWriter$writer){$args=$writer->formatArgs();return'Nette\Diagnostics\Debugger::barDump('.($node->args?"array(".$writer->write('%var',$args)." => $args)":'get_defined_vars()').', "Template " . str_replace(dirname(dirname($template->getFile())), "\xE2\x80\xA6", $template->getFile()))';}function
macroDebugbreak(MacroNode$node,PhpWriter$writer){return$writer->write(($node->args==NULL?'':'if (!(%node.args)); else').'if (function_exists("debugbreak")) debugbreak(); elseif (function_exists("xdebug_break")) xdebug_break()');}function
macroVar(MacroNode$node,PhpWriter$writer){if($node->name==='assign'){trigger_error('Macro {assign} is deprecated; use {var} instead.',E_USER_DEPRECATED);}$var=TRUE;$tokens=$writer->preprocess();$res=new
Latte\MacroTokens;while($tokens->nextToken()){if($var&&$tokens->isCurrent(Latte\MacroTokens::T_SYMBOL,Latte\MacroTokens::T_VARIABLE)){if($node->name==='default'){$res->append("'".ltrim($tokens->currentValue(),'$')."'");}else{$res->append('$'.ltrim($tokens->currentValue(),'$'));}$var=NULL;}elseif($tokens->isCurrent('=','=>')&&$tokens->depth===0){$res->append($node->name==='default'?'=>':'=');$var=FALSE;}elseif($tokens->isCurrent(',')&&$tokens->depth===0){$res->append($node->name==='default'?',':';');$var=TRUE;}elseif($var===NULL&&$node->name==='default'&&!$tokens->isCurrent(Latte\MacroTokens::T_WHITESPACE)){throw
new
CompileException("Unexpected '".$tokens->currentValue()."' in {default $node->args}");}else{$res->append($tokens->currentToken());}}$out=$writer->quoteFilter($res)->joinAll();return$node->name==='default'?"extract(array($out), EXTR_SKIP)":$out;}function
macroExpr(MacroNode$node,PhpWriter$writer){return$writer->write(($node->name==='?'?'':'echo ').'%modify(%node.args)');}static
function
includeTemplate($destination,array$params,Nette\Templating\ITemplate$template){if($destination
instanceof
Nette\Templating\ITemplate){$tpl=$destination;}elseif($destination==NULL){throw
new
Nette\InvalidArgumentException("Template file name was not specified.");}elseif($template
instanceof
Nette\Templating\IFileTemplate){if(substr($destination,0,1)!=='/'&&substr($destination,1,1)!==':'){$destination=dirname($template->getFile()).'/'.$destination;}$tpl=clone$template;$tpl->setFile($destination);}else{throw
new
Nette\NotSupportedException('Macro {include "filename"} is supported only with Nette\Templating\IFileTemplate.');}$tpl->setParameters($params);return$tpl;}static
function
initRuntime(Nette\Templating\ITemplate$template,$templateId){if(isset($template->_l)){$local=$template->_l;unset($template->_l);}else{$local=new\stdClass;}$local->templates[$templateId]=$template;if(!isset($template->_g)){$template->_g=new\stdClass;}return
array($local,$template->_g);}}use
Nette\Forms\Form;use
Nette\Utils\Strings;class
FormMacros
extends
MacroSet{static
function
install(Latte\Compiler$compiler){$me=new
static($compiler);$me->addMacro('form',array($me,'macroForm'),'Nette\Latte\Macros\FormMacros::renderFormEnd($_form)');$me->addMacro('formContainer',array($me,'macroFormContainer'),'$_form = array_pop($_formStack)');$me->addMacro('label',array($me,'macroLabel'),array($me,'macroLabelEnd'));$me->addMacro('input',array($me,'macroInput'),NULL,array($me,'macroInputAttr'));$me->addMacro('name',array($me,'macroName'),array($me,'macroNameEnd'),array($me,'macroNameAttr'));}function
macroForm(MacroNode$node,PhpWriter$writer){$name=$node->tokenizer->fetchWord();if($name===FALSE){throw
new
CompileException("Missing form name in {{$node->name}}.");}$node->tokenizer->reset();return$writer->write('Nette\Latte\Macros\FormMacros::renderFormBegin($form = $_form = '.($name[0]==='$'?'is_object(%node.word) ? %node.word : ':'').'$_control[%node.word], %node.array)');}function
macroFormContainer(MacroNode$node,PhpWriter$writer){$name=$node->tokenizer->fetchWord();if($name===FALSE){throw
new
CompileException("Missing form name in {{$node->name}}.");}$node->tokenizer->reset();return$writer->write('$_formStack[] = $_form; $formContainer = $_form = '.($name[0]==='$'?'is_object(%node.word) ? %node.word : ':'').'$_form[%node.word]');}function
macroLabel(MacroNode$node,PhpWriter$writer){$words=$node->tokenizer->fetchWords();if(!$words){throw
new
CompileException("Missing name in {{$node->name}}.");}$name=array_shift($words);return$writer->write(($name[0]==='$'?'$_input = is_object(%0.word) ? %0.word : $_form[%0.word]; if ($_label = $_input':'if ($_label = $_form[%0.word]').'->getLabel(%1.raw)) echo $_label->addAttributes(%node.array)',$name,($words?'NULL, ':'').implode(', ',array_map(array($writer,'formatWord'),$words)));}function
macroLabelEnd(MacroNode$node,PhpWriter$writer){if($node->content!=NULL){$node->openingCode=substr_replace($node->openingCode,'->startTag()',strrpos($node->openingCode,')')+1,0);return$writer->write('?></label><?php');}}function
macroInput(MacroNode$node,PhpWriter$writer){$words=$node->tokenizer->fetchWords();if(!$words){throw
new
CompileException("Missing name in {{$node->name}}.");}$name=array_shift($words);return$writer->write(($name[0]==='$'?'$_input = is_object(%0.word) ? %0.word : $_form[%0.word]; echo $_input':'echo $_form[%0.word]').'->getControl(%1.raw)->addAttributes(%node.array)',$name,implode(', ',array_map(array($writer,'formatWord'),$words)));}function
macroInputAttr(MacroNode$node,PhpWriter$writer){if(strtolower($node->htmlNode->name)==='input'){return$this->macroNameAttr($node,$writer);}else{throw
new
CompileException("Use n:name instead of n:input.");}}function
macroNameAttr(MacroNode$node,PhpWriter$writer){$words=$node->tokenizer->fetchWords();if(!$words){throw
new
CompileException("Missing name in n:{$node->name}.");}$name=array_shift($words);$tagName=strtolower($node->htmlNode->name);$node->isEmpty=!in_array($tagName,array('form','select','textarea'));if($tagName==='form'){return$writer->write('Nette\Latte\Macros\FormMacros::renderFormBegin($form = $_form = '.($name[0]==='$'?'is_object(%0.word) ? %0.word : ':'').'$_control[%0.word], %1.var, FALSE)',$name,array_fill_keys(array_keys($node->htmlNode->attrs),NULL));}else{return$writer->write('$_input = '.($name[0]==='$'?'is_object(%0.word) ? %0.word : ':'').'$_form[%0.word]; echo $_input'.($tagName==='label'?'->getLabel(%1.raw)':'->getControl(%1.raw)').($node->htmlNode->attrs?'->addAttributes(%2.var)':'').'->attributes()',$name,implode(', ',array_map(array($writer,'formatWord'),$words)),array_fill_keys(array_keys($node->htmlNode->attrs),NULL));}}function
macroName(MacroNode$node,PhpWriter$writer){if(!$node->htmlNode){throw
new
CompileException("Unknown macro {{$node->name}}, use n:{$node->name} attribute.");}elseif($node->prefix!==MacroNode::PREFIX_NONE){throw
new
CompileException("Unknown attribute n:{$node->prefix}-{$node->name}, use n:{$node->name} attribute.");}}function
macroNameEnd(MacroNode$node,PhpWriter$writer){preg_match('#(^.*?>)(.*)(<.*\z)#s',$node->content,$parts);if(strtolower($node->htmlNode->name)==='form'){$node->content=$parts[1].$parts[2].'<?php Nette\Latte\Macros\FormMacros::renderFormEnd($_form, FALSE) ?>'.$parts[3];}else{$node->content=$parts[1].'<?php echo $_input->getControl()->getHtml() ?>'.$parts[3];}}static
function
renderFormBegin(Form$form,array$attrs,$withTags=TRUE){foreach($form->getControls()as$control){$control->setOption('rendered',FALSE);}$el=$form->getElementPrototype();$el->action=$action=(string)$el->action;$el=clone$el;if(strcasecmp($form->getMethod(),'get')===0){$el->action=preg_replace('~\?[^#]*~','',$el->action,1);}$el->addAttributes($attrs);echo$withTags?$el->startTag():$el->attributes();}static
function
renderFormEnd(Form$form,$withTags=TRUE){$s='';if(strcasecmp($form->getMethod(),'get')===0){foreach(preg_split('#[;&]#',parse_url($form->getElementPrototype()->action,PHP_URL_QUERY),NULL,PREG_SPLIT_NO_EMPTY)as$param){$parts=explode('=',$param,2);$name=urldecode($parts[0]);if(!isset($form[$name])){$s.=Nette\Utils\Html::el('input',array('type'=>'hidden','name'=>$name,'value'=>urldecode($parts[1])));}}}foreach($form->getComponents(TRUE,'Nette\Forms\Controls\HiddenField')as$control){if(!$control->getOption('rendered')){$s.=$control->getControl();}}if(iterator_count($form->getComponents(TRUE,'Nette\Forms\Controls\TextInput'))<2){$s.='<!--[if IE]><input type=IEbug disabled style="display:none"><![endif]-->';}echo($s?"<div>$s</div>\n":'').($withTags?$form->getElementPrototype()->endTag()."\n":'');}}class
UIMacros
extends
MacroSet{private$namedBlocks=array();private$extends;static
function
install(Latte\Compiler$compiler){$me=new
static($compiler);$me->addMacro('include',array($me,'macroInclude'));$me->addMacro('includeblock',array($me,'macroIncludeBlock'));$me->addMacro('extends',array($me,'macroExtends'));$me->addMacro('layout',array($me,'macroExtends'));$me->addMacro('block',array($me,'macroBlock'),array($me,'macroBlockEnd'));$me->addMacro('#',array($me,'macroBlock'),array($me,'macroBlockEnd'));$me->addMacro('define',array($me,'macroBlock'),array($me,'macroBlockEnd'));$me->addMacro('snippet',array($me,'macroBlock'),array($me,'macroBlockEnd'));$me->addMacro('ifset',array($me,'macroIfset'),'endif');$me->addMacro('widget',array($me,'macroControl'));$me->addMacro('control',array($me,'macroControl'));$me->addMacro('href',NULL,NULL,function(MacroNode$node,PhpWriter$writer)use($me){return' ?> href="<?php '.$me->macroLink($node,$writer).' ?>"<?php ';});$me->addMacro('plink',array($me,'macroLink'));$me->addMacro('link',array($me,'macroLink'));$me->addMacro('ifCurrent',array($me,'macroIfCurrent'),'endif');$me->addMacro('contentType',array($me,'macroContentType'));$me->addMacro('status',array($me,'macroStatus'));}function
initialize(){$this->namedBlocks=array();$this->extends=NULL;}function
finalize(){$last=$this->getCompiler()->getMacroNode();if($last&&($last->name==='block'||$last->name==='#')){$this->getCompiler()->closeMacro($last->name);}$epilog=$prolog=array();if($this->namedBlocks){foreach($this->namedBlocks
as$name=>$code){$func='_lb'.substr(md5($this->getCompiler()->getTemplateId().$name),0,10).'_'.preg_replace('#[^a-z0-9_]#i','_',$name);$snippet=$name[0]==='_';$prolog[]="//\n// block $name\n//\n"."if (!function_exists(\$_l->blocks[".var_export($name,TRUE)."][] = '$func')) { "."function $func(\$_l, \$_args) { extract(\$_args)".($snippet?'; $_control->validateControl('.var_export(substr($name,1),TRUE).')':'')."\n?>$code<?php\n}}";}$prolog[]="//\n// end of blocks\n//";}if($this->namedBlocks||$this->extends){$prolog[]="// template extending and snippets support";$prolog[]='$_l->extends = '.($this->extends?$this->extends:'empty($template->_extended) && isset($_control) && $_control instanceof Nette\Application\UI\Presenter ? $_control->findLayoutTemplateFile() : NULL').'; $template->_extended = $_extended = TRUE;';$prolog[]='
if ($_l->extends) {
	'.($this->namedBlocks?'ob_start();':'return Nette\Latte\Macros\CoreMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render();').'

} elseif (!empty($_control->snippetMode)) {
	return Nette\Latte\Macros\UIMacros::renderSnippets($_control, $_l, get_defined_vars());
}';}else{$prolog[]='
// snippets support
if (!empty($_control->snippetMode)) {
	return Nette\Latte\Macros\UIMacros::renderSnippets($_control, $_l, get_defined_vars());
}';}return
array(implode("\n\n",$prolog),implode("\n",$epilog));}function
macroInclude(MacroNode$node,PhpWriter$writer){$destination=$node->tokenizer->fetchWord();if(substr($destination,0,1)!=='#'){return
FALSE;}$destination=ltrim($destination,'#');$parent=$destination==='parent';if($destination==='parent'||$destination==='this'){for($item=$node->parentNode;$item&&$item->name!=='block'&&!isset($item->data->name);$item=$item->parentNode);if(!$item){throw
new
CompileException("Cannot include $destination block outside of any block.");}$destination=$item->data->name;}$name=Strings::contains($destination,'$')?$destination:var_export($destination,TRUE);if(isset($this->namedBlocks[$destination])&&!$parent){$cmd="call_user_func(reset(\$_l->blocks[$name]), \$_l, %node.array? + get_defined_vars())";}else{$cmd='Nette\Latte\Macros\UIMacros::callBlock'.($parent?'Parent':'')."(\$_l, $name, %node.array? + ".($parent?'get_defined_vars':'$template->getParameters').'())';}if($node->modifiers){return$writer->write("ob_start(); $cmd; echo %modify(ob_get_clean())");}else{return$writer->write($cmd);}}function
macroIncludeBlock(MacroNode$node,PhpWriter$writer){return$writer->write('Nette\Latte\Macros\CoreMacros::includeTemplate(%node.word, %node.array? + get_defined_vars(), $_l->templates[%var])->render()',$this->getCompiler()->getTemplateId());}function
macroExtends(MacroNode$node,PhpWriter$writer){if(!$node->args){throw
new
CompileException('Missing destination in {'.$node->name.'}');}if(!empty($node->parentNode)){throw
new
CompileException('{'.$node->name.'} must be placed outside any macro.');}if($this->extends!==NULL){throw
new
CompileException('Multiple {'.$node->name.'} declarations are not allowed.');}if($node->args==='none'){$this->extends='FALSE';}elseif($node->args==='auto'){$this->extends='$_presenter->findLayoutTemplateFile()';}else{$this->extends=$writer->write('%node.word%node.args');}return;}function
macroBlock(MacroNode$node,PhpWriter$writer){$name=$node->tokenizer->fetchWord();if($node->name==='block'&&$name===FALSE){return$node->modifiers===''?'':'ob_start()';}$node->data->name=$name=ltrim($name,'#');if($name==NULL){if($node->name!=='snippet'){throw
new
CompileException("Missing block name.");}}elseif(Strings::contains($name,'$')){if($node->name==='snippet'){for($parent=$node->parentNode;$parent&&$parent->name!=='snippet';$parent=$parent->parentNode);if(!$parent){throw
new
CompileException("Dynamic snippets are allowed only inside static snippet.");}$parent->data->dynamic=TRUE;$node->data->leave=TRUE;$node->closingCode="<?php \$_dynSnippets[\$_dynSnippetId] = ob_get_flush() ?>";if($node->prefix){$node->attrCode=$writer->write("<?php echo ' id=\"' . (\$_dynSnippetId = \$_control->getSnippetId({$writer->formatWord($name)})) . '\"' ?>");return$writer->write('ob_start()');}$tag=trim($node->tokenizer->fetchWord(),'<>');$tag=$tag?$tag:'div';$node->closingCode.="\n</$tag>";return$writer->write("?>\n<$tag id=\"<?php echo \$_dynSnippetId = \$_control->getSnippetId({$writer->formatWord($name)}) ?>\"><?php ob_start()");}else{$node->data->leave=TRUE;$fname=$writer->formatWord($name);$node->closingCode="<?php }} ".($node->name==='define'?'':"call_user_func(reset(\$_l->blocks[$fname]), \$_l, get_defined_vars())")." ?>";$func='_lb'.substr(md5($this->getCompiler()->getTemplateId().$name),0,10).'_'.preg_replace('#[^a-z0-9_]#i','_',$name);return"\n\n//\n// block $name\n//\n"."if (!function_exists(\$_l->blocks[$fname]['{$this->getCompiler()->getTemplateId()}'] = '$func')) { "."function $func(\$_l, \$_args) { extract(\$_args)";}}if($node->name==='snippet'){$node->data->name=$name='_'.$name;}if(isset($this->namedBlocks[$name])){throw
new
CompileException("Cannot redeclare static block '$name'");}$prolog=$this->namedBlocks?'':"if (\$_l->extends) { ob_end_clean(); return Nette\\Latte\\Macros\\CoreMacros::includeTemplate(\$_l->extends, get_defined_vars(), \$template)->render(); }\n";$top=empty($node->parentNode);$this->namedBlocks[$name]=TRUE;$include='call_user_func(reset($_l->blocks[%var]), $_l, '.($node->name==='snippet'?'$template->getParameters()':'get_defined_vars()').')';if($node->modifiers){$include="ob_start(); $include; echo %modify(ob_get_clean())";}if($node->name==='snippet'){if($node->prefix){$node->attrCode=$writer->write('<?php echo \' id="\' . $_control->getSnippetId(%var) . \'"\' ?>',(string)substr($name,1));return$writer->write($prolog.$include,$name);}$tag=trim($node->tokenizer->fetchWord(),'<>');$tag=$tag?$tag:'div';return$writer->write("$prolog ?>\n<$tag id=\"<?php echo \$_control->getSnippetId(%var) ?>\"><?php $include ?>\n</$tag><?php ",(string)substr($name,1),$name);}elseif($node->name==='define'){return$prolog;}else{return$writer->write($prolog.$include,$name);}}function
macroBlockEnd(MacroNode$node,PhpWriter$writer){if(isset($node->data->name)){if($node->name==='snippet'&&$node->prefix===MacroNode::PREFIX_NONE&&preg_match('#^.*? n:\w+>\n?#s',$node->content,$m1)&&preg_match('#[ \t]*<[^<]+\z#s',$node->content,$m2)){$node->openingCode=$m1[0].$node->openingCode;$node->content=substr($node->content,strlen($m1[0]),-strlen($m2[0]));$node->closingCode.=$m2[0];}if(empty($node->data->leave)){if(!empty($node->data->dynamic)){$node->content.='<?php if (isset($_dynSnippets)) return $_dynSnippets; ?>';}$this->namedBlocks[$node->data->name]=$tmp=rtrim(ltrim($node->content,"\n")," \t");$node->content=substr_replace($node->content,$node->openingCode."\n",strspn($node->content,"\n"),strlen($tmp));$node->openingCode="<?php ?>";}}elseif($node->modifiers){return$writer->write('echo %modify(ob_get_clean())');}}function
macroIfset(MacroNode$node,PhpWriter$writer){if(!Strings::contains($node->args,'#')){return
FALSE;}$list=array();while(($name=$node->tokenizer->fetchWord())!==FALSE){$list[]=$name[0]==='#'?'$_l->blocks["'.substr($name,1).'"]':$name;}return'if (isset('.implode(', ',$list).')):';}function
macroControl(MacroNode$node,PhpWriter$writer){if($node->name==='widget'){trigger_error('Macro {widget} is deprecated; use {control} instead.',E_USER_DEPRECATED);}$words=$node->tokenizer->fetchWords();if(!$words){throw
new
CompileException("Missing control name in {control}");}$name=$writer->formatWord($words[0]);$method=isset($words[1])?ucfirst($words[1]):'';$method=Strings::match($method,'#^\w*\z#')?"render$method":"{\"render$method\"}";$param=$writer->formatArray();if(!Strings::contains($node->args,'=>')){$param=substr($param,6,-1);}return($name[0]==='$'?"if (is_object($name)) \$_ctrl = $name; else ":'').'$_ctrl = $_control->getComponent('.$name.'); '.'if ($_ctrl instanceof Nette\Application\UI\IRenderable) $_ctrl->validateControl(); '.($node->modifiers===''?"\$_ctrl->$method($param)":$writer->write("ob_start(); \$_ctrl->$method($param); echo %modify(ob_get_clean())"));}function
macroLink(MacroNode$node,PhpWriter$writer){return$writer->write('echo %escape(%modify('.($node->name==='plink'?'$_presenter':'$_control').'->link(%node.word, %node.array?)))');}function
macroIfCurrent(MacroNode$node,PhpWriter$writer){return$writer->write(($node->args?'try { $_presenter->link(%node.word, %node.array?); } catch (Nette\Application\UI\InvalidLinkException $e) {}':'').'; if ($_presenter->getLastCreatedRequestFlag("current")):');}function
macroContentType(MacroNode$node,PhpWriter$writer){if(Strings::contains($node->args,'xhtml')){$this->getCompiler()->setContentType(Latte\Compiler::CONTENT_XHTML);}elseif(Strings::contains($node->args,'html')){$this->getCompiler()->setContentType(Latte\Compiler::CONTENT_HTML);}elseif(Strings::contains($node->args,'xml')){$this->getCompiler()->setContentType(Latte\Compiler::CONTENT_XML);}elseif(Strings::contains($node->args,'javascript')){$this->getCompiler()->setContentType(Latte\Compiler::CONTENT_JS);}elseif(Strings::contains($node->args,'css')){$this->getCompiler()->setContentType(Latte\Compiler::CONTENT_CSS);}elseif(Strings::contains($node->args,'calendar')){$this->getCompiler()->setContentType(Latte\Compiler::CONTENT_ICAL);}else{$this->getCompiler()->setContentType(Latte\Compiler::CONTENT_TEXT);}if(Strings::contains($node->args,'/')){return$writer->write('$netteHttpResponse->setHeader("Content-Type", %var)',$node->args);}}function
macroStatus(MacroNode$node,PhpWriter$writer){return$writer->write((substr($node->args,-1)==='?'?'if (!$netteHttpResponse->isSent()) ':'').'$netteHttpResponse->setCode(%var)',(int)$node->args);}static
function
callBlock(\stdClass$context,$name,array$params){if(empty($context->blocks[$name])){throw
new
Nette\InvalidStateException("Cannot include undefined block '$name'.");}$block=reset($context->blocks[$name]);$block($context,$params);}static
function
callBlockParent(\stdClass$context,$name,array$params){if(empty($context->blocks[$name])||($block=next($context->blocks[$name]))===FALSE){throw
new
Nette\InvalidStateException("Cannot include undefined parent block '$name'.");}$block($context,$params);}static
function
renderSnippets(Nette\Application\UI\Control$control,\stdClass$local,array$params){$control->snippetMode=FALSE;$payload=$control->getPresenter()->getPayload();if(isset($local->blocks)){foreach($local->blocks
as$name=>$function){if($name[0]!=='_'||!$control->isControlInvalid(substr($name,1))){continue;}ob_start();$function=reset($function);$snippets=$function($local,$params);$payload->snippets[$id=$control->getSnippetId(substr($name,1))]=ob_get_clean();if($snippets){$payload->snippets+=$snippets;unset($payload->snippets[$id]);}}}$control->snippetMode=TRUE;if($control
instanceof
Nette\Application\UI\IRenderable){$queue=array($control);do{foreach(array_shift($queue)->getComponents()as$child){if($child
instanceof
Nette\Application\UI\IRenderable){if($child->isControlInvalid()){$child->snippetMode=TRUE;$child->render();$child->snippetMode=FALSE;}}elseif($child
instanceof
Nette\ComponentModel\IContainer){$queue[]=$child;}}}while($queue);}}}}namespace Nette\Utils{use
Nette;class
TokenIterator
extends
Nette\Object{public$tokens;public$position=-1;public$ignored=array();function
__construct(array$tokens){$this->tokens=$tokens;}function
currentToken(){return
isset($this->tokens[$this->position])?$this->tokens[$this->position]:NULL;}function
currentValue(){return
isset($this->tokens[$this->position])?$this->tokens[$this->position][Tokenizer::VALUE]:NULL;}function
nextToken(){return$this->scan(func_get_args(),TRUE,TRUE);}function
nextValue(){return$this->scan(func_get_args(),TRUE,TRUE,TRUE);}function
nextAll(){return$this->scan(func_get_args(),FALSE,TRUE);}function
nextUntil($arg){return$this->scan(func_get_args(),FALSE,TRUE,FALSE,TRUE);}function
joinAll(){return$this->scan(func_get_args(),FALSE,TRUE,TRUE);}function
joinUntil($arg){return$this->scan(func_get_args(),FALSE,TRUE,TRUE,TRUE);}function
isCurrent($arg){if(!isset($this->tokens[$this->position])){return
FALSE;}$args=func_get_args();$token=$this->tokens[$this->position];return
in_array($token[Tokenizer::VALUE],$args,TRUE)||(isset($token[Tokenizer::TYPE])&&in_array($token[Tokenizer::TYPE],$args,TRUE));}function
isNext(){return(bool)$this->scan(func_get_args(),TRUE,FALSE);}function
isPrev(){return(bool)$this->scan(func_get_args(),TRUE,FALSE,FALSE,FALSE,TRUE);}function
reset(){$this->position=-1;return$this;}protected
function
next(){$this->position++;}private
function
scan($wanted,$onlyFirst,$advance,$strings=FALSE,$until=FALSE,$prev=FALSE){$res=$onlyFirst?NULL:($strings?'':array());$pos=$this->position+($prev?-1:1);do{if(!isset($this->tokens[$pos])){if(!$wanted&&$advance&&!$prev&&$pos<=count($this->tokens)){$this->next();}return$res;}$token=$this->tokens[$pos];$type=isset($token[Tokenizer::TYPE])?$token[Tokenizer::TYPE]:NULL;if(!$wanted||(in_array($token[Tokenizer::VALUE],$wanted,TRUE)||in_array($type,$wanted,TRUE))^$until){while($advance&&!$prev&&$pos>$this->position){$this->next();}if($onlyFirst){return$strings?$token[Tokenizer::VALUE]:$token;}elseif($strings){$res.=$token[Tokenizer::VALUE];}else{$res[]=$token;}}elseif($until||!in_array($type,$this->ignored,TRUE)){return$res;}$pos+=$prev?-1:1;}while(TRUE);}}}namespace Nette\Latte{use
Nette;class
MacroTokens
extends
Nette\Utils\TokenIterator{const
T_WHITESPACE=1,T_COMMENT=2,T_SYMBOL=3,T_NUMBER=4,T_VARIABLE=5,T_STRING=6,T_CAST=7,T_KEYWORD=8,T_CHAR=9;private
static$tokenizer;public$depth=0;function
__construct($input=NULL){parent::__construct(is_array($input)?$input:$this->parse($input));$this->ignored=array(self::T_COMMENT,self::T_WHITESPACE);}function
parse($s){self::$tokenizer=self::$tokenizer?:new
Nette\Utils\Tokenizer(array(self::T_WHITESPACE=>'\s+',self::T_COMMENT=>'(?s)/\*.*?\*/',self::T_STRING=>Parser::RE_STRING,self::T_KEYWORD=>'(?:true|false|null|and|or|xor|clone|new|instanceof|return|continue|break|[A-Z_][A-Z0-9_]{2,})(?![\w\pL_])',self::T_CAST=>'\((?:expand|string|array|int|integer|float|bool|boolean|object)\)',self::T_VARIABLE=>'\$[\w\pL_]+',self::T_NUMBER=>'[+-]?[0-9]+(?:\.[0-9]+)?(?:e[0-9]+)?',self::T_SYMBOL=>'[\w\pL_]+(?:-[\w\pL_]+)*',self::T_CHAR=>'::|=>|[^"\']'),'u');return
self::$tokenizer->tokenize($s);}function
append($val,$position=NULL){if($val!=NULL){array_splice($this->tokens,$position===NULL?count($this->tokens):$position,0,is_array($val)?array($val):$this->parse($val));}return$this;}function
prepend($val){if($val!=NULL){array_splice($this->tokens,0,0,is_array($val)?array($val):$this->parse($val));}return$this;}function
fetchWord(){$words=$this->fetchWords();return$words?implode(':',$words):FALSE;}function
fetchWords(){do{$words[]=$this->joinUntil(self::T_WHITESPACE,',',':');}while($this->nextToken(':'));$this->nextToken(',');$this->nextAll(self::T_WHITESPACE,self::T_COMMENT);return$words===array('')?array():$words;}function
reset(){$this->depth=0;return
parent::reset();}protected
function
next(){parent::next();if($this->isCurrent('[','(','{')){$this->depth++;}elseif($this->isPrev(']',')','}')){$this->depth--;}}}use
Nette\Utils\Strings;class
Parser
extends
Nette\Object{const
RE_STRING='\'(?:\\\\.|[^\'\\\\])*\'|"(?:\\\\.|[^"\\\\])*"';const
N_PREFIX='n:';public$defaultSyntax='latte';public$shortNoEscape=TRUE;public$syntaxes=array('latte'=>array('\\{(?![\\s\'"{}])','\\}'),'double'=>array('\\{\\{(?![\\s\'"{}])','\\}\\}'),'asp'=>array('<%\s*','\s*%>'),'python'=>array('\\{[{%]\s*','\s*[%}]\\}'),'off'=>array('[^\x00-\xFF]',''));private$macroRe;private$input;private$output;private$offset;private$context;private$lastHtmlTag;private$syntaxEndTag;private$xmlMode;const
CONTEXT_HTML_TEXT='htmlText',CONTEXT_CDATA='cdata',CONTEXT_HTML_TAG='htmlTag',CONTEXT_HTML_ATTRIBUTE='htmlAttribute',CONTEXT_RAW='raw',CONTEXT_HTML_COMMENT='htmlComment';function
parse($input){if(substr($input,0,3)==="\xEF\xBB\xBF"){$input=substr($input,3);}if(!Strings::checkEncoding($input)){throw
new
Nette\InvalidArgumentException('Template is not valid UTF-8 stream.');}$input=str_replace("\r\n","\n",$input);$this->input=$input;$this->output=array();$this->offset=0;$this->setSyntax($this->defaultSyntax);$this->setContext(self::CONTEXT_HTML_TEXT);$this->lastHtmlTag=$this->syntaxEndTag=NULL;while($this->offset<strlen($input)){$matches=$this->{"context".$this->context[0]}();if(!$matches){break;}elseif(!empty($matches['comment'])){$this->addToken(Token::COMMENT,$matches[0]);}elseif(!empty($matches['macro'])){$token=$this->addToken(Token::MACRO_TAG,$matches[0]);list($token->name,$token->value,$token->modifiers,$token->empty)=$this->parseMacroTag($matches['macro']);}$this->filter();}if($this->offset<strlen($input)){$this->addToken(Token::TEXT,substr($this->input,$this->offset));}return$this->output;}private
function
contextHtmlText(){$matches=$this->match('~
			(?:(?<=\n|^)[ \t]*)?<(?P<closing>/?)(?P<tag>[a-z0-9:]+)|  ##  begin of HTML tag <tag </tag - ignores <!DOCTYPE
			<(?P<htmlcomment>!--)|     ##  begin of HTML comment <!--
			'.$this->macroRe.'         ##  macro tag
		~xsi');if(!empty($matches['htmlcomment'])){$this->addToken(Token::HTML_TAG_BEGIN,$matches[0]);$this->setContext(self::CONTEXT_HTML_COMMENT);}elseif(!empty($matches['tag'])){$token=$this->addToken(Token::HTML_TAG_BEGIN,$matches[0]);$token->name=$matches['tag'];$token->closing=(bool)$matches['closing'];$this->lastHtmlTag=$matches['closing'].strtolower($matches['tag']);$this->setContext(self::CONTEXT_HTML_TAG);}return$matches;}private
function
contextCData(){$matches=$this->match('~
			</(?P<tag>'.$this->lastHtmlTag.')(?![a-z0-9:])| ##  end HTML tag </tag
			'.$this->macroRe.'              ##  macro tag
		~xsi');if(!empty($matches['tag'])){$token=$this->addToken(Token::HTML_TAG_BEGIN,$matches[0]);$token->name=$this->lastHtmlTag;$token->closing=TRUE;$this->lastHtmlTag='/'.$this->lastHtmlTag;$this->setContext(self::CONTEXT_HTML_TAG);}return$matches;}private
function
contextHtmlTag(){$matches=$this->match('~
			(?P<end>\ ?/?>)([ \t]*\n)?|  ##  end of HTML tag
			'.$this->macroRe.'|          ##  macro tag
			\s*(?P<attr>[^\s/>={]+)(?:\s*=\s*(?P<value>["\']|[^\s/>{]+))? ## begin of HTML attribute
		~xsi');if(!empty($matches['end'])){$this->addToken(Token::HTML_TAG_END,$matches[0]);$this->setContext(!$this->xmlMode&&in_array($this->lastHtmlTag,array('script','style'))?self::CONTEXT_CDATA:self::CONTEXT_HTML_TEXT);}elseif(isset($matches['attr'])&&$matches['attr']!==''){$token=$this->addToken(Token::HTML_ATTRIBUTE,$matches[0]);$token->name=$matches['attr'];$token->value=isset($matches['value'])?$matches['value']:'';if($token->value==='"'||$token->value==="'"){if(Strings::startsWith($token->name,self::N_PREFIX)){$token->value='';if($m=$this->match('~(.*?)'.$matches['value'].'~xsi')){$token->value=$m[1];$token->text.=$m[0];}}else{$this->setContext(self::CONTEXT_HTML_ATTRIBUTE,$matches['value']);}}}return$matches;}private
function
contextHtmlAttribute(){$matches=$this->match('~
			(?P<quote>'.$this->context[1].')|  ##  end of HTML attribute
			'.$this->macroRe.'                 ##  macro tag
		~xsi');if(!empty($matches['quote'])){$this->addToken(Token::TEXT,$matches[0]);$this->setContext(self::CONTEXT_HTML_TAG);}return$matches;}private
function
contextHtmlComment(){$matches=$this->match('~
			(?P<htmlcomment>--\s*>)|   ##  end of HTML comment
			'.$this->macroRe.'         ##  macro tag
		~xsi');if(!empty($matches['htmlcomment'])){$this->addToken(Token::HTML_TAG_END,$matches[0]);$this->setContext(self::CONTEXT_HTML_TEXT);}return$matches;}private
function
contextRaw(){$matches=$this->match('~
			'.$this->macroRe.'     ##  macro tag
		~xsi');return$matches;}private
function
match($re){if($matches=Strings::match($this->input,$re,PREG_OFFSET_CAPTURE,$this->offset)){$value=substr($this->input,$this->offset,$matches[0][1]-$this->offset);if($value!==''){$this->addToken(Token::TEXT,$value);}$this->offset=$matches[0][1]+strlen($matches[0][0]);foreach($matches
as$k=>$v)$matches[$k]=$v[0];}return$matches;}function
setContext($context,$quote=NULL){$this->context=array($context,$quote);return$this;}function
setSyntax($type){$type=$type?:$this->defaultSyntax;if(isset($this->syntaxes[$type])){$this->setDelimiters($this->syntaxes[$type][0],$this->syntaxes[$type][1]);}else{throw
new
Nette\InvalidArgumentException("Unknown syntax '$type'");}return$this;}function
setDelimiters($left,$right){$this->macroRe='
			(?P<comment>'.$left.'\\*.*?\\*'.$right.'\n{0,2})|
			'.$left.'
				(?P<macro>(?:'.self::RE_STRING.'|\{
						(?P<inner>'.self::RE_STRING.'|\{(?P>inner)\}|[^\'"{}])*+
				\}|[^\'"{}])+?)
			'.$right.'
			(?P<rmargin>[ \t]*(?=\n))?
		';return$this;}function
parseMacroTag($tag){$match=Strings::match($tag,'~^
			(
				(?P<name>\?|/?[a-z]\w*+(?:[.:]\w+)*+(?!::|\(|\\\\))|   ## ?, name, /name, but not function( or class:: or namespace\
				(?P<noescape>!?)(?P<shortname>/?[=\~#%^&_]?)      ## !expression, !=expression, ...
			)(?P<args>.*?)
			(?P<modifiers>\|[a-z](?:'.Parser::RE_STRING.'|[^\'"])*)?
			(?P<empty>/?\z)
		()\z~isx');if(!$match){return
FALSE;}if($match['name']===''){$match['name']=$match['shortname']?:'=';if($match['noescape']){if(!$this->shortNoEscape){throw
new
CompileException("The noescape shortcut (exclamation mark) is not enabled, use the noescape modifier on line {$this->getLine()}.");}$match['modifiers'].='|noescape';}}return
array($match['name'],trim($match['args']),$match['modifiers'],(bool)$match['empty']);}private
function
addToken($type,$text){$this->output[]=$token=new
Token;$token->type=$type;$token->text=$text;$token->line=$this->getLine();return$token;}private
function
getLine(){return
substr_count($this->input,"\n",0,max(1,$this->offset-1))+1;}protected
function
filter(){$token=end($this->output);if($token->type===Token::MACRO_TAG&&$token->name==='/syntax'){$this->setSyntax($this->defaultSyntax);$token->type=Token::COMMENT;}elseif($token->type===Token::MACRO_TAG&&$token->name==='syntax'){$this->setSyntax($token->value);$token->type=Token::COMMENT;}elseif($token->type===Token::HTML_ATTRIBUTE&&$token->name==='n:syntax'){$this->setSyntax($token->value);$this->syntaxEndTag='/'.$this->lastHtmlTag;$token->type=Token::COMMENT;}elseif($token->type===Token::HTML_TAG_END&&$this->lastHtmlTag===$this->syntaxEndTag){$this->setSyntax($this->defaultSyntax);}elseif($token->type===Token::MACRO_TAG&&$token->name==='contentType'){if(preg_match('#html|xml#',$token->value,$m)){$this->xmlMode=$m[0]==='xml';$this->setContext(self::CONTEXT_HTML_TEXT);}else{$this->setContext(self::CONTEXT_RAW);}}}}class
PhpWriter
extends
Nette\Object{private$tokens;private$modifiers;private$compiler;static
function
using(MacroNode$node,Compiler$compiler=NULL){return
new
static($node->tokenizer,$node->modifiers,$compiler);}function
__construct(MacroTokens$tokens,$modifiers=NULL,Compiler$compiler=NULL){$this->tokens=$tokens;$this->modifiers=$modifiers;$this->compiler=$compiler;}function
write($mask){$me=$this;$mask=Nette\Utils\Strings::replace($mask,'#%escape(\(([^()]*+|(?1))+\))#',function($m)use($me){return$me->escapeFilter(new
MacroTokens(substr($m[1],1,-1)))->joinAll();});$mask=Nette\Utils\Strings::replace($mask,'#%modify(\(([^()]*+|(?1))+\))#',function($m)use($me){return$me->formatModifiers(substr($m[1],1,-1));});$args=func_get_args();$pos=$this->tokens->position;$word=strpos($mask,'%node.word')===FALSE?NULL:$this->tokens->fetchWord();$code=Nette\Utils\Strings::replace($mask,'#([,+]\s*)?%(node\.|\d+\.|)(word|var|raw|array|args)(\?)?(\s*\+\s*)?()#',function($m)use($me,$word,&$args){list(,$l,$source,$format,$cond,$r)=$m;switch($source){case'node.':$arg=$word;break;case'':$arg=next($args);break;default:$arg=$args[$source+1];break;}switch($format){case'word':$code=$me->formatWord($arg);break;case'args':$code=$me->formatArgs();break;case'array':$code=$me->formatArray();$code=$cond&&$code==='array()'?'':$code;break;case'var':$code=var_export($arg,TRUE);break;case'raw':$code=(string)$arg;break;}if($cond&&$code===''){return$r?$l:$r;}else{return$l.$code.$r;}});$this->tokens->position=$pos;return$code;}function
formatModifiers($var){$tokens=new
MacroTokens(ltrim($this->modifiers,'|'));$tokens=$this->preprocess($tokens);$tokens=$this->modifiersFilter($tokens,$var);$tokens=$this->quoteFilter($tokens);return$tokens->joinAll();}function
formatArgs(MacroTokens$tokens=NULL){$tokens=$this->preprocess($tokens);$tokens=$this->quoteFilter($tokens);return$tokens->joinAll();}function
formatArray(){$tokens=$this->preprocess();$tokens=$this->expandFilter($tokens);$tokens=$this->quoteFilter($tokens);return$tokens->joinAll();}function
formatWord($s){return(is_numeric($s)||preg_match('#^\$|[\'"]|^true\z|^false\z|^null\z#i',$s))?$this->formatArgs(new
MacroTokens($s)):'"'.$s.'"';}function
preprocess(MacroTokens$tokens=NULL){$tokens=$tokens===NULL?$this->tokens:$tokens;$tokens=$this->removeCommentsFilter($tokens);$tokens=$this->shortTernaryFilter($tokens);$tokens=$this->shortArraysFilter($tokens);return$tokens;}function
removeCommentsFilter(MacroTokens$tokens){$res=new
MacroTokens;while($tokens->nextToken()){if(!$tokens->isCurrent(MacroTokens::T_COMMENT)){$res->append($tokens->currentToken());}}return$res;}function
shortTernaryFilter(MacroTokens$tokens){$res=new
MacroTokens;$inTernary=array();while($tokens->nextToken()){if($tokens->isCurrent('?')){$inTernary[]=$tokens->depth;}elseif($tokens->isCurrent(':')){array_pop($inTernary);}elseif(end($inTernary)===$tokens->depth&&$tokens->isCurrent(',',')',']')){$res->append(' : NULL');array_pop($inTernary);}$res->append($tokens->currentToken());}if($inTernary){$res->append(' : NULL');}return$res;}function
shortArraysFilter(MacroTokens$tokens){$res=new
MacroTokens;$arrays=array();while($tokens->nextToken()){if($tokens->isCurrent('[')){if($arrays[]=!$tokens->isPrev(']',')',MacroTokens::T_SYMBOL,MacroTokens::T_VARIABLE,MacroTokens::T_KEYWORD)){$res->append('array(');continue;}}elseif($tokens->isCurrent(']')){if(array_pop($arrays)===TRUE){$res->append(')');continue;}}$res->append($tokens->currentToken());}return$res;}function
expandFilter(MacroTokens$tokens){$res=new
MacroTokens('array(');$expand=NULL;while($tokens->nextToken()){if($tokens->isCurrent('(expand)')&&$tokens->depth===0){$expand=TRUE;$res->append('),');}elseif($expand&&$tokens->isCurrent(',')&&!$tokens->depth){$expand=FALSE;$res->append(', array(');}else{$res->append($tokens->currentToken());}}if($expand!==NULL){$res->prepend('array_merge(')->append($expand?', array()':')');}return$res->append(')');}function
quoteFilter(MacroTokens$tokens){$res=new
MacroTokens;while($tokens->nextToken()){$res->append($tokens->isCurrent(MacroTokens::T_SYMBOL)&&(!$tokens->isPrev()||$tokens->isPrev(',','(','[','=','=>',':','?'))&&(!$tokens->isNext()||$tokens->isNext(',',')',']','=','=>',':','?'))?"'".$tokens->currentValue()."'":$tokens->currentToken());}return$res;}function
modifiersFilter(MacroTokens$tokens,$var){$inside=FALSE;$res=new
MacroTokens($var);while($tokens->nextToken()){if($tokens->isCurrent(MacroTokens::T_WHITESPACE)){$res->append(' ');}elseif($inside){if($tokens->isCurrent(':',',')){$res->append(', ');$tokens->nextAll(MacroTokens::T_WHITESPACE);}elseif($tokens->isCurrent('|')){$res->append(')');$inside=FALSE;}else{$res->append($tokens->currentToken());}}else{if($tokens->isCurrent(MacroTokens::T_SYMBOL)){if($this->compiler&&$tokens->isCurrent('escape')){$res=$this->escapeFilter($res);$tokens->nextToken('|');}else{$res->prepend('$template->'.$tokens->currentValue().'(');$inside=TRUE;}}else{throw
new
CompileException("Modifier name must be alphanumeric string, '".$tokens->currentValue()."' given.");}}}if($inside){$res->append(')');}return$res;}function
escapeFilter(MacroTokens$tokens){$tokens=clone$tokens;switch($this->compiler->getContentType()){case
Compiler::CONTENT_XHTML:case
Compiler::CONTENT_HTML:$context=$this->compiler->getContext();switch($context[0]){case
Compiler::CONTEXT_SINGLE_QUOTED_ATTR:case
Compiler::CONTEXT_DOUBLE_QUOTED_ATTR:case
Compiler::CONTEXT_UNQUOTED_ATTR:if($context[1]===Compiler::CONTENT_JS){$tokens->prepend('Nette\Templating\Helpers::escapeJs(')->append(')');}elseif($context[1]===Compiler::CONTENT_CSS){$tokens->prepend('Nette\Templating\Helpers::escapeCss(')->append(')');}$tokens->prepend('htmlSpecialChars(')->append($context[0]===Compiler::CONTEXT_SINGLE_QUOTED_ATTR?', ENT_QUOTES)':')');if($context[0]===Compiler::CONTEXT_UNQUOTED_ATTR){$tokens->prepend("'\"' . ")->append(" . '\"'");}return$tokens;case
Compiler::CONTEXT_COMMENT:return$tokens->prepend('Nette\Templating\Helpers::escapeHtmlComment(')->append(')');return;case
Compiler::CONTENT_JS:case
Compiler::CONTENT_CSS:return$tokens->prepend('Nette\Templating\Helpers::escape'.ucfirst($context[0]).'(')->append(')');default:return$tokens->prepend('Nette\Templating\Helpers::escapeHtml(')->append(', ENT_NOQUOTES)');}case
Compiler::CONTENT_XML:case
Compiler::CONTENT_JS:case
Compiler::CONTENT_CSS:case
Compiler::CONTENT_ICAL:return$tokens->prepend('Nette\Templating\Helpers::escape'.ucfirst($this->compiler->getContentType()).'(')->append(')');case
Compiler::CONTENT_TEXT:return$tokens;default:return$tokens->prepend('$template->escape(')->append(')');}}}class
Token
extends
Nette\Object{const
TEXT='text',MACRO_TAG='macroTag',HTML_TAG_BEGIN='htmlTagBegin',HTML_TAG_END='htmlTagEnd',HTML_ATTRIBUTE='htmlAttribute',COMMENT='comment';public$type;public$text;public$line;public$name;public$value;public$modifiers;public$closing;public$empty;}}namespace Nette\Loaders{use
Nette;use
Nette\Caching\Cache;class
RobotLoader
extends
AutoLoader{const
RETRY_LIMIT=3;public$ignoreDirs='.*, *.old, *.bak, *.tmp, temp';public$filters=array('php'=>NULL,'php5'=>NULL);public$autoRebuild=TRUE;private$scanDirs=array();private$classes=array();private$rebuilt=FALSE;private$missing=array();private$cacheStorage;private$phpCacheStorage;function
__construct(){if(!extension_loaded('tokenizer')){throw
new
Nette\NotSupportedException("PHP extension Tokenizer is not loaded.");}}function
register($prepend=FALSE){$this->classes=$this->getCache()->load($this->getKey(),array($this,'_rebuildCallback'));parent::register($prepend);return$this;}function
tryLoad($type){$type=ltrim(strtolower($type),'\\');$info=&$this->classes[$type];if(isset($this->missing[$type])||(is_int($info)&&$info>=self::RETRY_LIMIT)){return;}if($this->autoRebuild){if(!is_array($info)||!is_file($info['file'])){$info=is_int($info)?$info+1:0;if($this->rebuilt){$this->getCache()->save($this->getKey(),$this->classes);}else{$this->rebuild();}}elseif(!$this->rebuilt&&(filemtime($info['file'])!==$info['time']||(!empty($info['filter'])&&!$this->getPhpCache()->load($info['file'])))){$this->updateFile($info['file']);if(!isset($this->classes[$type])){$this->classes[$type]=0;}$this->getCache()->save($this->getKey(),$this->classes);}}if(isset($this->classes[$type]['file'])){if(empty($this->classes[$type]['filter'])){Nette\Utils\LimitedScope::load($this->classes[$type]['file'],TRUE);}else{$item=$this->getPhpCache()->load($this->classes[$type]['file']);Nette\Utils\LimitedScope::load($item['file'],TRUE);}self::$count++;}else{$this->missing[$type]=TRUE;}}function
addDirectory($path){foreach((array)$path
as$val){$real=realpath($val);if($real===FALSE){throw
new
Nette\DirectoryNotFoundException("Directory '$val' not found.");}$this->scanDirs[]=$real;}return$this;}function
getIndexedClasses(){$res=array();foreach($this->classes
as$class=>$info){if(is_array($info)){$res[$info['orig']]=$info['file'];}}return$res;}function
rebuild(){$this->rebuilt=TRUE;$this->getCache()->save($this->getKey(),Nette\Utils\Callback::closure($this,'_rebuildCallback'));}function
_rebuildCallback(){$files=$missing=array();foreach($this->classes
as$class=>$info){if(is_array($info)){$files[$info['file']]['time']=$info['time'];$files[$info['file']]['filter']=!empty($info['filter']);$files[$info['file']]['classes'][]=$info['orig'];}else{$missing[$class]=$info;}}$this->classes=array();foreach(array_unique($this->scanDirs)as$dir){foreach($this->createFileIterator($dir)as$file){$file=$file->getPathname();if(isset($files[$file])&&$files[$file]['time']==filemtime($file)){$classes=$files[$file]['classes'];$filtered=$files[$file]['filter'];}else{list($classes,$filtered)=$this->processFile($file);}foreach($classes
as$class){$info=&$this->classes[strtolower($class)];if(isset($info['file'])){throw
new
Nette\InvalidStateException("Ambiguous class $class resolution; defined in {$info['file']} and in $file.");}$info=array('file'=>$file,'time'=>filemtime($file),'orig'=>$class);if($filtered){$info['filter']=TRUE;}}}}$this->classes+=$missing;return$this->classes;}private
function
createFileIterator($dir){if(!is_dir($dir)){return
new\ArrayIterator(array(new\SplFileInfo($dir)));}$ignoreDirs=is_array($this->ignoreDirs)?$this->ignoreDirs:preg_split('#[,\s]+#',$this->ignoreDirs);$disallow=array();foreach($ignoreDirs
as$item){if($item=realpath($item)){$disallow[$item]=TRUE;}}$iterator=Nette\Utils\Finder::findFiles(array_map(function($ext){return"*.$ext";},array_keys($this->filters)))->filter(function($file)use(&$disallow){return!isset($disallow[$file->getPathname()]);})->from($dir)->exclude($ignoreDirs)->filter($filter=function($dir)use(&$disallow){$path=$dir->getPathname();if(is_file("$path/netterobots.txt")){foreach(file("$path/netterobots.txt")as$s){if(preg_match('#^(?:disallow\\s*:)?\\s*(\\S+)#i',$s,$matches)){$disallow[$path.str_replace('/',DIRECTORY_SEPARATOR,rtrim('/'.ltrim($matches[1],'/'),'/'))]=TRUE;}}}return!isset($disallow[$path]);});$filter(new\SplFileInfo($dir));return$iterator;}private
function
updateFile($file){foreach($this->classes
as$class=>$info){if(isset($info['file'])&&$info['file']===$file){unset($this->classes[$class]);}}if(is_file($file)){list($classes,$filtered)=$this->processFile($file);foreach($classes
as$class){$info=&$this->classes[strtolower($class)];if(isset($info['file'])&&@filemtime($info['file'])!==$info['time']){$this->updateFile($info['file']);$info=&$this->classes[strtolower($class)];}if($this->rebuilt){return;}if(isset($info['file'])){throw
new
Nette\InvalidStateException("Ambiguous class $class resolution; defined in {$info['file']} and in $file.");}$info=array('file'=>$file,'time'=>filemtime($file),'orig'=>$class);if($filtered){$info['filter']=TRUE;}}}}private
function
processFile($file){$filtered=FALSE;$code=file_get_contents($file);$ext=pathinfo($file,PATHINFO_EXTENSION);if(!empty($this->filters[$ext])){$res=call_user_func($this->filters[$ext],$code);if($filtered=($code!==$res)){$this->getPhpCache()->save($file,$code=$res);}}return
array($this->scanPhp($code),$filtered);}private
function
scanPhp($code){$T_TRAIT=PHP_VERSION_ID<50400?-1:T_TRAIT;$expected=FALSE;$namespace='';$level=$minLevel=0;$classes=array();if(preg_match('#//nette'.'loader=(\S*)#',$code,$matches)){foreach(explode(',',$matches[1])as$name){$classes[]=$name;}return$classes;}foreach(@token_get_all($code)as$token){if(is_array($token)){switch($token[0]){case
T_COMMENT:case
T_DOC_COMMENT:case
T_WHITESPACE:continue
2;case
T_NS_SEPARATOR:case
T_STRING:if($expected){$name.=$token[1];}continue
2;case
T_NAMESPACE:case
T_CLASS:case
T_INTERFACE:case$T_TRAIT:$expected=$token[0];$name='';continue
2;case
T_CURLY_OPEN:case
T_DOLLAR_OPEN_CURLY_BRACES:$level++;}}if($expected){switch($expected){case
T_CLASS:case
T_INTERFACE:case$T_TRAIT:if($level===$minLevel){$classes[]=$namespace.$name;}break;case
T_NAMESPACE:$namespace=$name?$name.'\\':'';$minLevel=$token==='{'?1:0;}$expected=NULL;}if($token==='{'){$level++;}elseif($token==='}'){$level--;}}return$classes;}function
setCacheStorage(Nette\Caching\IStorage$storage,Nette\Caching\Storages\PhpFileStorage$phpCacheStorage=NULL){$this->cacheStorage=$storage;$this->phpCacheStorage=$phpCacheStorage;return$this;}function
getCacheStorage(){return$this->cacheStorage;}protected
function
getCache(){if(!$this->cacheStorage){trigger_error('Missing cache storage.',E_USER_WARNING);$this->cacheStorage=new
Nette\Caching\Storages\DevNullStorage;}return
new
Cache($this->cacheStorage,'Nette.RobotLoader');}protected
function
getPhpCache(){return
new
Cache($this->phpCacheStorage,'Nette.RobotLoader.filters');}protected
function
getKey(){return
array($this->ignoreDirs,array_keys($this->filters),$this->scanDirs);}}}namespace Nette\Mail{use
Nette;use
Nette\Utils\Strings;class
MimePart
extends
Nette\Object{const
ENCODING_BASE64='base64',ENCODING_7BIT='7bit',ENCODING_8BIT='8bit',ENCODING_QUOTED_PRINTABLE='quoted-printable';const
EOL="\r\n";const
LINE_LENGTH=76;private$headers=array();private$parts=array();private$body;function
setHeader($name,$value,$append=FALSE){if(!$name||preg_match('#[^a-z0-9-]#i',$name)){throw
new
Nette\InvalidArgumentException("Header name must be non-empty alphanumeric string, '$name' given.");}if($value==NULL){if(!$append){unset($this->headers[$name]);}}elseif(is_array($value)){$tmp=&$this->headers[$name];if(!$append||!is_array($tmp)){$tmp=array();}foreach($value
as$email=>$recipient){if($recipient!==NULL&&!Strings::checkEncoding($recipient)){Nette\Utils\Validators::assert($recipient,'unicode',"header '$name'");}if(preg_match('#[\r\n]#',$recipient)){throw
new
Nette\InvalidArgumentException("Name must not contain line separator.");}Nette\Utils\Validators::assert($email,'email',"header '$name'");$tmp[$email]=$recipient;}}else{$value=(string)$value;if(!Strings::checkEncoding($value)){throw
new
Nette\InvalidArgumentException("Header is not valid UTF-8 string.");}$this->headers[$name]=preg_replace('#[\r\n]+#',' ',$value);}return$this;}function
getHeader($name){return
isset($this->headers[$name])?$this->headers[$name]:NULL;}function
clearHeader($name){unset($this->headers[$name]);return$this;}function
getEncodedHeader($name){$offset=strlen($name)+2;if(!isset($this->headers[$name])){return
NULL;}elseif(is_array($this->headers[$name])){$s='';foreach($this->headers[$name]as$email=>$name){if($name!=NULL){$s.=self::encodeHeader($name,$offset,strpbrk($name,'.,;<@>()[]"=?'));$email=" <$email>";}$email.=',';if($s!==''&&$offset+strlen($email)>self::LINE_LENGTH){$s.=self::EOL."\t";$offset=1;}$s.=$email;$offset+=strlen($email);}return
substr($s,0,-1);}elseif(preg_match('#^(\S+; (?:file)?name=)"(.*)"\z#',$this->headers[$name],$m)){$offset+=strlen($m[1]);return$m[1].'"'.self::encodeHeader($m[2],$offset).'"';}else{return
self::encodeHeader($this->headers[$name],$offset);}}function
getHeaders(){return$this->headers;}function
setContentType($contentType,$charset=NULL){$this->setHeader('Content-Type',$contentType.($charset?"; charset=$charset":''));return$this;}function
setEncoding($encoding){$this->setHeader('Content-Transfer-Encoding',$encoding);return$this;}function
getEncoding(){return$this->getHeader('Content-Transfer-Encoding');}function
addPart(MimePart$part=NULL){return$this->parts[]=$part===NULL?new
self:$part;}function
setBody($body){if($body
instanceof
Nette\Templating\ITemplate){$body->mail=$this;$body=$body->__toString(TRUE);}$this->body=$body;return$this;}function
getBody(){return$this->body;}function
getEncodedMessage(){$output='';$boundary='--------'.Strings::random();foreach($this->headers
as$name=>$value){$output.=$name.': '.$this->getEncodedHeader($name);if($this->parts&&$name==='Content-Type'){$output.=';'.self::EOL."\tboundary=\"$boundary\"";}$output.=self::EOL;}$output.=self::EOL;$body=(string)$this->body;if($body!==''){switch($this->getEncoding()){case
self::ENCODING_QUOTED_PRINTABLE:$output.=function_exists('quoted_printable_encode')?quoted_printable_encode($body):self::encodeQuotedPrintable($body);break;case
self::ENCODING_BASE64:$output.=rtrim(chunk_split(base64_encode($body),self::LINE_LENGTH,self::EOL));break;case
self::ENCODING_7BIT:$body=preg_replace('#[\x80-\xFF]+#','',$body);case
self::ENCODING_8BIT:$body=str_replace(array("\x00","\r"),'',$body);$body=str_replace("\n",self::EOL,$body);$output.=$body;break;default:throw
new
Nette\InvalidStateException('Unknown encoding.');}}if($this->parts){if(substr($output,-strlen(self::EOL))!==self::EOL){$output.=self::EOL;}foreach($this->parts
as$part){$output.='--'.$boundary.self::EOL.$part->getEncodedMessage().self::EOL;}$output.='--'.$boundary.'--';}return$output;}private
static
function
encodeHeader($s,&$offset=0,$force=FALSE){$o='';if($offset>=55){$o=self::EOL."\t";$offset=1;}if(!$force&&strspn($s,"!\"#$%&\'()*+,-./0123456789:;<>@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\\]^`abcdefghijklmnopqrstuvwxyz{|}=? _\r\n\t")===strlen($s)&&($offset+strlen($s)<=self::LINE_LENGTH)){$offset+=strlen($s);return$o.$s;}$o.=str_replace("\n ","\n\t",substr(iconv_mime_encode(str_repeat(' ',$offset),$s,array('scheme'=>'B','input-charset'=>'UTF-8','output-charset'=>'UTF-8')),$offset+2));$offset=strlen($o)-strrpos($o,"\n");return$o;}}class
Message
extends
MimePart{const
HIGH=1,NORMAL=3,LOW=5;public
static$defaultMailer='Nette\Mail\SendmailMailer';public
static$defaultHeaders=array('MIME-Version'=>'1.0','X-Mailer'=>'Nette Framework');private$mailer;private$attachments=array();private$inlines=array();private$html;function
__construct(){foreach(static::$defaultHeaders
as$name=>$value){$this->setHeader($name,$value);}$this->setHeader('Date',date('r'));}function
setFrom($email,$name=NULL){$this->setHeader('From',$this->formatEmail($email,$name));return$this;}function
getFrom(){return$this->getHeader('From');}function
addReplyTo($email,$name=NULL){$this->setHeader('Reply-To',$this->formatEmail($email,$name),TRUE);return$this;}function
setSubject($subject){$this->setHeader('Subject',$subject);return$this;}function
getSubject(){return$this->getHeader('Subject');}function
addTo($email,$name=NULL){$this->setHeader('To',$this->formatEmail($email,$name),TRUE);return$this;}function
addCc($email,$name=NULL){$this->setHeader('Cc',$this->formatEmail($email,$name),TRUE);return$this;}function
addBcc($email,$name=NULL){$this->setHeader('Bcc',$this->formatEmail($email,$name),TRUE);return$this;}private
function
formatEmail($email,$name){if(!$name&&preg_match('#^(.+) +<(.*)>\z#',$email,$matches)){return
array($matches[2]=>$matches[1]);}else{return
array($email=>$name);}}function
setReturnPath($email){$this->setHeader('Return-Path',$email);return$this;}function
getReturnPath(){return$this->getHeader('Return-Path');}function
setPriority($priority){$this->setHeader('X-Priority',(int)$priority);return$this;}function
getPriority(){return$this->getHeader('X-Priority');}function
setHtmlBody($html,$basePath=NULL){if($html
instanceof
Nette\Templating\ITemplate){$html->mail=$this;if($basePath===NULL&&$html
instanceof
Nette\Templating\IFileTemplate){$basePath=dirname($html->getFile());}$html=$html->__toString(TRUE);}if($basePath!==FALSE){$cids=array();$matches=Strings::matchAll($html,'#(src\s*=\s*|background\s*=\s*|url\()(["\'])(?![a-z]+:|[/\\#])(.+?)\\2#i',PREG_OFFSET_CAPTURE);foreach(array_reverse($matches)as$m){$file=rtrim($basePath,'/\\').'/'.$m[3][0];if(!isset($cids[$file])){$cids[$file]=substr($this->addEmbeddedFile($file)->getHeader("Content-ID"),1,-1);}$html=substr_replace($html,"{$m[1][0]}{$m[2][0]}cid:{$cids[$file]}{$m[2][0]}",$m[0][1],strlen($m[0][0]));}}$this->html=$html;if($this->getSubject()==NULL&&$matches=Strings::match($html,'#<title>(.+?)</title>#is')){$this->setSubject(html_entity_decode($matches[1],ENT_QUOTES,'UTF-8'));}if($this->getBody()==NULL&&$html!=NULL){$this->setBody($this->buildText($html));}return$this;}function
getHtmlBody(){return$this->html;}function
addEmbeddedFile($file,$content=NULL,$contentType=NULL){return$this->inlines[$file]=$this->createAttachment($file,$content,$contentType,'inline')->setHeader('Content-ID',$this->getRandomId());}function
addAttachment($file,$content=NULL,$contentType=NULL){return$this->attachments[]=$this->createAttachment($file,$content,$contentType,'attachment');}private
function
createAttachment($file,$content,$contentType,$disposition){$part=new
MimePart;if($content===NULL){$content=@file_get_contents($file);if($content===FALSE){throw
new
Nette\FileNotFoundException("Unable to read file '$file'.");}}else{$content=(string)$content;}$part->setBody($content);$part->setContentType($contentType?$contentType:Nette\Utils\MimeTypeDetector::fromString($content));$part->setEncoding(preg_match('#(multipart|message)/#A',$contentType)?self::ENCODING_8BIT:self::ENCODING_BASE64);$part->setHeader('Content-Disposition',$disposition.'; filename="'.Strings::fixEncoding(basename($file)).'"');return$part;}function
send(){trigger_error(__METHOD__.'() is deprecated; use IMailer::send() instead.',E_USER_DEPRECATED);$this->getMailer()->send($this);}function
setMailer(IMailer$mailer){$this->mailer=$mailer;return$this;}function
getMailer(){trigger_error(__METHOD__.'() is deprecated.',E_USER_DEPRECATED);if($this->mailer===NULL){$this->mailer=is_object(static::$defaultMailer)?static::$defaultMailer:new
static::$defaultMailer;}return$this->mailer;}function
generateMessage(){return$this->build()->getEncodedMessage();}protected
function
build(){$mail=clone$this;$mail->setHeader('Message-ID',$this->getRandomId());$cursor=$mail;if($mail->attachments){$tmp=$cursor->setContentType('multipart/mixed');$cursor=$cursor->addPart();foreach($mail->attachments
as$value){$tmp->addPart($value);}}if($mail->html!=NULL){$tmp=$cursor->setContentType('multipart/alternative');$cursor=$cursor->addPart();$alt=$tmp->addPart();if($mail->inlines){$tmp=$alt->setContentType('multipart/related');$alt=$alt->addPart();foreach($mail->inlines
as$name=>$value){$tmp->addPart($value);}}$alt->setContentType('text/html','UTF-8')->setEncoding(preg_match('#\S{990}#',$mail->html)?self::ENCODING_QUOTED_PRINTABLE:(preg_match('#[\x80-\xFF]#',$mail->html)?self::ENCODING_8BIT:self::ENCODING_7BIT))->setBody($mail->html);}$text=$mail->getBody();$mail->setBody(NULL);$cursor->setContentType('text/plain','UTF-8')->setEncoding(preg_match('#\S{990}#',$text)?self::ENCODING_QUOTED_PRINTABLE:(preg_match('#[\x80-\xFF]#',$text)?self::ENCODING_8BIT:self::ENCODING_7BIT))->setBody($text);return$mail;}protected
function
buildText($html){$text=Strings::replace($html,array('#<(style|script|head).*</\\1>#Uis'=>'','#<t[dh][ >]#i'=>" $0",'#[\r\n]+#'=>' ','#<(/?p|/?h\d|li|br|/tr)[ >/]#i'=>"\n$0"));$text=html_entity_decode(strip_tags($text),ENT_QUOTES,'UTF-8');$text=Strings::replace($text,'#[ \t]+#',' ');return
trim($text);}private
function
getRandomId(){return'<'.Strings::random().'@'.(isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:(isset($_SERVER['SERVER_NAME'])?$_SERVER['SERVER_NAME']:'localhost')).'>';}}class
SendmailMailer
extends
Nette\Object
implements
IMailer{public$commandArgs;function
send(Message$mail){$tmp=clone$mail;$tmp->setHeader('Subject',NULL);$tmp->setHeader('To',NULL);$parts=explode(Message::EOL.Message::EOL,$tmp->generateMessage(),2);$args=array(str_replace(Message::EOL,PHP_EOL,$mail->getEncodedHeader('To')),str_replace(Message::EOL,PHP_EOL,$mail->getEncodedHeader('Subject')),str_replace(Message::EOL,PHP_EOL,$parts[1]),str_replace(Message::EOL,PHP_EOL,$parts[0]));if($this->commandArgs){$args[]=(string)$this->commandArgs;}if(call_user_func_array('mail',$args)===FALSE){$error=error_get_last();throw
new
Nette\InvalidStateException("Unable to send email: $error[message].");}}}class
SmtpMailer
extends
Nette\Object
implements
IMailer{private$connection;private$host;private$port;private$username;private$password;private$secure;private$timeout;private$persistent;function
__construct(array$options=array()){if(isset($options['host'])){$this->host=$options['host'];$this->port=isset($options['port'])?(int)$options['port']:NULL;}else{$this->host=ini_get('SMTP');$this->port=(int)ini_get('smtp_port');}$this->username=isset($options['username'])?$options['username']:'';$this->password=isset($options['password'])?$options['password']:'';$this->secure=isset($options['secure'])?$options['secure']:'';$this->timeout=isset($options['timeout'])?(int)$options['timeout']:20;if(!$this->port){$this->port=$this->secure==='ssl'?465:25;}$this->persistent=!empty($options['persistent']);}function
send(Message$mail){$mail=clone$mail;try{if(!$this->connection){$this->connect();}if(($from=$mail->getHeader('Return-Path'))||($from=key($mail->getHeader('From')))){$this->write("MAIL FROM:<$from>",250);}foreach(array_merge((array)$mail->getHeader('To'),(array)$mail->getHeader('Cc'),(array)$mail->getHeader('Bcc'))as$email=>$name){$this->write("RCPT TO:<$email>",array(250,251));}$mail->setHeader('Bcc',NULL);$data=$mail->generateMessage();$this->write('DATA',354);$data=preg_replace('#^\.#m','..',$data);$this->write($data);$this->write('.',250);if(!$this->persistent){$this->write('QUIT',221);$this->disconnect();}}catch(SmtpException$e){if($this->connection){$this->disconnect();}throw$e;}}protected
function
connect(){$this->connection=@fsockopen(($this->secure==='ssl'?'ssl://':'').$this->host,$this->port,$errno,$error,$this->timeout);if(!$this->connection){throw
new
SmtpException($error,$errno);}stream_set_timeout($this->connection,$this->timeout,0);$this->read();$self=isset($_SERVER['SERVER_NAME'])?$_SERVER['SERVER_NAME']:'localhost';$this->write("EHLO $self");if((int)$this->read()!==250){$this->write("HELO $self",250);}if($this->secure==='tls'){$this->write('STARTTLS',220);if(!stream_socket_enable_crypto($this->connection,TRUE,STREAM_CRYPTO_METHOD_TLS_CLIENT)){throw
new
SmtpException('Unable to connect via TLS.');}$this->write("EHLO $self",250);}if($this->username!=NULL&&$this->password!=NULL){$this->write('AUTH LOGIN',334);$this->write(base64_encode($this->username),334,'username');$this->write(base64_encode($this->password),235,'password');}}protected
function
disconnect(){fclose($this->connection);$this->connection=NULL;}protected
function
write($line,$expectedCode=NULL,$message=NULL){fwrite($this->connection,$line.Message::EOL);if($expectedCode&&!in_array((int)$this->read(),(array)$expectedCode)){throw
new
SmtpException('SMTP server did not accept '.($message?$message:$line));}}protected
function
read(){$s='';while(($line=fgets($this->connection,1e3))!=NULL){$s.=$line;if(substr($line,3,1)===' '){break;}}return$s;}}class
SmtpException
extends\Exception{}}namespace Nette\PhpGenerator{use
Nette;use
Nette\Utils\Strings;/**
 * Class/Interface/Trait description.
 *
 * @author     David Grudl
 *
 * @method ClassType setName(string)
 * @method string getName()
 * @method ClassType setType(string)
 * @method string getType()
 * @method ClassType setFinal(bool)
 * @method bool isFinal()
 * @method ClassType setAbstract(bool)
 * @method bool isAbstract()
 * @method ClassType setExtends(string[]|string)
 * @method string[]|string getExtends()
 * @method ClassType addExtend(string)
 * @method ClassType setImplements(string[])
 * @method string[] getImplements()
 * @method ClassType addImplement(string)
 * @method ClassType setTraits(string[])
 * @method string[] getTraits()
 * @method ClassType addTrait(string)
 * @method ClassType setDocuments(string[])
 * @method string[] getDocuments()
 * @method ClassType addDocument(string)
 * @method ClassType setConsts(scalar[])
 * @method scalar[] getConsts()
 * @method ClassType setProperties(Property[])
 * @method Property[] getProperties()
 * @method ClassType setMethods(Method[])
 * @method Method[] getMethods()
 */class
ClassType
extends
Nette\Object{private$name;private$type='class';private$final;private$abstract;private$extends=array();private$implements=array();private$traits=array();private$documents=array();private$consts=array();private$properties=array();private$methods=array();static
function
from($from){$from=$from
instanceof\ReflectionClass?$from:new\ReflectionClass($from);$class=new
static($from->getShortName());$class->type=$from->isInterface()?'interface':(PHP_VERSION_ID>=50400&&$from->isTrait()?'trait':'class');$class->final=$from->isFinal();$class->abstract=$from->isAbstract()&&$class->type==='class';$class->implements=$from->getInterfaceNames();$class->documents=preg_replace('#^\s*\* ?#m','',trim($from->getDocComment(),"/* \r\n"));$namespace=$from->getNamespaceName();if($from->getParentClass()){$class->extends=$from->getParentClass()->getName();if($namespace){$class->extends=Strings::startsWith($class->extends,"$namespace\\")?substr($class->extends,strlen($namespace)+1):'\\'.$class->extends;}$class->implements=array_diff($class->implements,$from->getParentClass()->getInterfaceNames());}if($namespace){foreach($class->implements
as&$interface){$interface=Strings::startsWith($interface,"$namespace\\")?substr($interface,strlen($namespace)+1):'\\'.$interface;}}foreach($from->getProperties()as$prop){$class->properties[$prop->getName()]=Property::from($prop);}foreach($from->getMethods()as$method){if($method->getDeclaringClass()==$from){$class->methods[$method->getName()]=Method::from($method);}}return$class;}function
__construct($name=NULL){$this->name=$name;}function
addConst($name,$value){$this->consts[$name]=$value;return$this;}function
addProperty($name,$value=NULL){$property=new
Property;return$this->properties[$name]=$property->setName($name)->setValue($value);}function
addMethod($name){$method=new
Method;if($this->type==='interface'){$method->setVisibility('')->setBody(FALSE);}else{$method->setVisibility('public');}return$this->methods[$name]=$method->setName($name);}function
__toString(){$consts=array();foreach($this->consts
as$name=>$value){$consts[]="const $name = ".Helpers::dump($value).";\n";}$properties=array();foreach($this->properties
as$property){$properties[]=($property->documents?str_replace("\n","\n * ","/**\n".implode("\n",(array)$property->documents))."\n */\n":'').$property->visibility.($property->static?' static':'').' $'.$property->name.($property->value===NULL?'':' = '.Helpers::dump($property->value)).";\n";}return
Strings::normalize(($this->documents?str_replace("\n","\n * ","/**\n".implode("\n",(array)$this->documents))."\n */\n":'').($this->abstract?'abstract ':'').($this->final?'final ':'').$this->type.' '.$this->name.' '.($this->extends?'extends '.implode(', ',(array)$this->extends).' ':'').($this->implements?'implements '.implode(', ',(array)$this->implements).' ':'')."\n{\n\n".Strings::indent(($this->traits?"use ".implode(', ',(array)$this->traits).";\n\n":'').($this->consts?implode('',$consts)."\n\n":'').($this->properties?implode("\n",$properties)."\n\n":'').implode("\n\n\n",$this->methods),1)."\n\n}")."\n";}}class
Helpers{const
PHP_IDENT='[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*';static
function
dump($var){return
self::_dump($var);}private
static
function
_dump(&$var,$level=0){if($var
instanceof
PhpLiteral){return(string)$var;}elseif(is_float($var)){$var=var_export($var,TRUE);return
strpos($var,'.')===FALSE?$var.'.0':$var;}elseif(is_bool($var)){return$var?'TRUE':'FALSE';}elseif(is_string($var)&&(preg_match('#[^\x09\x20-\x7E\xA0-\x{10FFFF}]#u',$var)||preg_last_error())){static$table;if($table===NULL){foreach(array_merge(range("\x00","\x1F"),range("\x7F","\xFF"))as$ch){$table[$ch]='\x'.str_pad(dechex(ord($ch)),2,'0',STR_PAD_LEFT);}$table['\\']='\\\\';$table["\r"]='\r';$table["\n"]='\n';$table["\t"]='\t';$table['$']='\$';$table['"']='\"';}return'"'.strtr($var,$table).'"';}elseif(is_array($var)){$space=str_repeat("\t",$level);static$marker;if($marker===NULL){$marker=uniqid("\x00",TRUE);}if(empty($var)){$out='';}elseif($level>50||isset($var[$marker])){throw
new
Nette\InvalidArgumentException('Nesting level too deep or recursive dependency.');}else{$out='';$outAlt="\n$space";$var[$marker]=TRUE;$counter=0;foreach($var
as$k=>&$v){if($k!==$marker){$item=($k===$counter?'':self::_dump($k,$level+1).' => ').self::_dump($v,$level+1);$counter=is_int($k)?max($k+1,$counter):$counter;$out.=($out===''?'':', ').$item;$outAlt.="\t$item,\n$space";}}unset($var[$marker]);}return'array('.(strpos($out,"\n")===FALSE&&strlen($out)<40?$out:$outAlt).')';}elseif(is_object($var)){$arr=(array)$var;$space=str_repeat("\t",$level);static$list=array();if(empty($arr)){$out='';}elseif($level>50||in_array($var,$list,TRUE)){throw
new
Nette\InvalidArgumentException('Nesting level too deep or recursive dependency.');}else{$out="\n";$list[]=$var;foreach($arr
as$k=>&$v){if($k[0]==="\x00"){$k=substr($k,strrpos($k,"\x00")+1);}$out.="$space\t".self::_dump($k,$level+1)." => ".self::_dump($v,$level+1).",\n";}array_pop($list);$out.=$space;}return
get_class($var)==='stdClass'?"(object) array($out)":__CLASS__."::createObject('".get_class($var)."', array($out))";}elseif(is_resource($var)){throw
new
Nette\InvalidArgumentException('Cannot dump resource.');}else{return
var_export($var,TRUE);}}static
function
format($statement){$args=func_get_args();return
self::formatArgs(array_shift($args),$args);}static
function
formatArgs($statement,array$args){$a=strpos($statement,'?');while($a!==FALSE){if(!$args){throw
new
Nette\InvalidArgumentException('Insufficient number of arguments.');}$arg=array_shift($args);if(substr($statement,$a+1,1)==='*'){if(!is_array($arg)){throw
new
Nette\InvalidArgumentException('Argument must be an array.');}$arg=implode(', ',array_map(array(__CLASS__,'dump'),$arg));$statement=substr_replace($statement,$arg,$a,2);}else{$arg=substr($statement,$a-1,1)==='$'||in_array(substr($statement,$a-2,2),array('->','::'))?self::formatMember($arg):self::_dump($arg);$statement=substr_replace($statement,$arg,$a,1);}$a=strpos($statement,'?',$a+strlen($arg));}return$statement;}static
function
formatMember($name){return$name
instanceof
PhpLiteral||!self::isIdentifier($name)?'{'.self::_dump($name).'}':$name;}static
function
isIdentifier($value){return
is_string($value)&&preg_match('#^'.self::PHP_IDENT.'\z#',$value);}static
function
createObject($class,array$props){return
unserialize('O'.substr(serialize((string)$class),1,-1).substr(serialize($props),1));}}/**
 * Class method description.
 *
 * @author     David Grudl
 *
 * @method Method setName(string)
 * @method string getName()
 * @method Method setParameters(Parameter[])
 * @method Parameter[] getParameters()
 * @method Method setUses(array)
 * @method array getUses()
 * @method string getBody()
 * @method Method setStatic(bool)
 * @method bool isStatic()
 * @method Method setVisibility(string)
 * @method string getVisibility()
 * @method Method setFinal(bool)
 * @method bool isFinal()
 * @method Method setAbstract(bool)
 * @method bool isAbstract()
 * @method Method setReturnReference(bool)
 * @method bool getReturnReference()
 * @method Method setDocuments(string[])
 * @method string[] getDocuments()
 * @method Method addDocument(string)
 */class
Method
extends
Nette\Object{private$name;private$parameters=array();private$uses=array();private$body;private$static;private$visibility;private$final;private$abstract;private$returnReference;private$documents=array();static
function
from($from){$from=$from
instanceof\ReflectionMethod?$from:new\ReflectionMethod($from);$method=new
static;$method->name=$from->getName();foreach($from->getParameters()as$param){$method->parameters[$param->getName()]=Parameter::from($param);}$method->static=$from->isStatic();$method->visibility=$from->isPrivate()?'private':($from->isProtected()?'protected':'');$method->final=$from->isFinal();$method->abstract=$from->isAbstract()&&!$from->getDeclaringClass()->isInterface();$method->body=$from->isAbstract()?FALSE:'';$method->returnReference=$from->returnsReference();$method->documents=preg_replace('#^\s*\* ?#m','',trim($from->getDocComment(),"/* \r\n"));return$method;}function
addParameter($name,$defaultValue=NULL){$param=new
Parameter;if(func_num_args()>1){$param->setOptional(TRUE)->setDefaultValue($defaultValue);}return$this->parameters[$name]=$param->setName($name);}function
addUse($name){$param=new
Parameter;return$this->uses[]=$param->setName($name);}function
setBody($statement,array$args=NULL){$this->body=func_num_args()>1?Helpers::formatArgs($statement,$args):$statement;return$this;}function
addBody($statement,array$args=NULL){$this->body.=(func_num_args()>1?Helpers::formatArgs($statement,$args):$statement)."\n";return$this;}function
__toString(){$parameters=array();foreach($this->parameters
as$param){$parameters[]=($param->typeHint?$param->typeHint.' ':'').($param->reference?'&':'').'$'.$param->name.($param->optional?' = '.Helpers::dump($param->defaultValue):'');}$uses=array();foreach($this->uses
as$param){$uses[]=($param->reference?'&':'').'$'.$param->name;}return($this->documents?str_replace("\n","\n * ","/**\n".implode("\n",(array)$this->documents))."\n */\n":'').($this->abstract?'abstract ':'').($this->final?'final ':'').($this->visibility?$this->visibility.' ':'').($this->static?'static ':'').'function'.($this->returnReference?' &':'').($this->name?' '.$this->name:'').'('.implode(', ',$parameters).')'.($this->uses?' use ('.implode(', ',$uses).')':'').($this->abstract||$this->body===FALSE?';':($this->name?"\n":' ')."{\n".Nette\Utils\Strings::indent(trim($this->body),1)."\n}");}}/**
 * Method parameter description.
 *
 * @author     David Grudl
 *
 * @method Parameter setName(string)
 * @method string getName()
 * @method Parameter setReference(bool)
 * @method bool isReference()
 * @method Parameter setTypeHint(string)
 * @method string getTypeHint()
 * @method Parameter setOptional(bool)
 * @method bool isOptional()
 * @method Parameter setDefaultValue(mixed)
 * @method mixed getDefaultValue()
 */class
Parameter
extends
Nette\Object{private$name;private$reference;private$typeHint;private$optional;public$defaultValue;static
function
from(\ReflectionParameter$from){$param=new
static;$param->name=$from->getName();$param->reference=$from->isPassedByReference();try{$param->typeHint=$from->isArray()?'array':($from->getClass()?'\\'.$from->getClass()->getName():'');}catch(\ReflectionException$e){if(preg_match('#Class (.+) does not exist#',$e->getMessage(),$m)){$param->typeHint='\\'.$m[1];}else{throw$e;}}$param->optional=PHP_VERSION_ID<50407?$from->isOptional()||($param->typeHint&&$from->allowsNull()):$from->isDefaultValueAvailable();$param->defaultValue=(PHP_VERSION_ID===50316?$from->isOptional():$from->isDefaultValueAvailable())?$from->getDefaultValue():NULL;$namespace=$from->getDeclaringClass()->getNamespaceName();$namespace=$namespace?"\\$namespace\\":"\\";if(Nette\Utils\Strings::startsWith($param->typeHint,$namespace)){$param->typeHint=substr($param->typeHint,strlen($namespace));}return$param;}}class
PhpLiteral{private$value;function
__construct($value){$this->value=(string)$value;}function
__toString(){return$this->value;}}/**
 * Class property description.
 *
 * @author     David Grudl
 *
 * @method Property setName(string)
 * @method string getName()
 * @method Property setValue(mixed)
 * @method mixed getValue()
 * @method Property setStatic(bool)
 * @method bool isStatic()
 * @method Property setVisibility(string)
 * @method string getVisibility()
 * @method Property setDocuments(string[])
 * @method string[] getDocuments()
 * @method Property addDocument(string)
 */class
Property
extends
Nette\Object{private$name;public$value;private$static;private$visibility='public';private$documents=array();static
function
from(\ReflectionProperty$from){$prop=new
static;$prop->name=$from->getName();$defaults=$from->getDeclaringClass()->getDefaultProperties();$prop->value=isset($defaults[$from->name])?$defaults[$from->name]:NULL;$prop->static=$from->isStatic();$prop->visibility=$from->isPrivate()?'private':($from->isProtected()?'protected':'public');$prop->documents=preg_replace('#^\s*\* ?#m','',trim($from->getDocComment(),"/* \r\n"));return$prop;}}}namespace Nette\Reflection{use
Nette;class
Annotation
extends
Nette\Object
implements
IAnnotation{function
__construct(array$values){foreach($values
as$k=>$v){$this->$k=$v;}}function
__toString(){return$this->value;}}use
Nette\Utils\Strings;/**
 * Annotations support for PHP.
 *
 * @author     David Grudl
 * @Annotation
 */final
class
AnnotationsParser{const
RE_STRING='\'(?:\\\\.|[^\'\\\\])*\'|"(?:\\\\.|[^"\\\\])*"';const
RE_IDENTIFIER='[_a-zA-Z\x7F-\xFF][_a-zA-Z0-9\x7F-\xFF-\\\]*';public
static$useReflection;public
static$inherited=array('description','param','return');private
static$cache;private
static$timestamps;private
static$cacheStorage;final
function
__construct(){throw
new
Nette\StaticClassException;}static
function
getAll(\Reflector$r){if($r
instanceof\ReflectionClass){$type=$r->getName();$member='';}elseif($r
instanceof\ReflectionMethod){$type=$r->getDeclaringClass()->getName();$member=$r->getName();}else{$type=$r->getDeclaringClass()->getName();$member='$'.$r->getName();}if(!self::$useReflection){$file=$r
instanceof\ReflectionClass?$r->getFileName():$r->getDeclaringClass()->getFileName();if($file&&isset(self::$timestamps[$file])&&self::$timestamps[$file]!==filemtime($file)){unset(self::$cache[$type]);}unset(self::$timestamps[$file]);}if(isset(self::$cache[$type][$member])){return
self::$cache[$type][$member];}if(self::$useReflection===NULL){self::$useReflection=(bool)ClassType::from(__CLASS__)->getDocComment();}if(self::$useReflection){$annotations=self::parseComment($r->getDocComment());}else{if(!self::$cacheStorage){self::$cacheStorage=new
Nette\Caching\Storages\DevNullStorage;}$outerCache=new
Nette\Caching\Cache(self::$cacheStorage,'Nette.Reflection.Annotations');if(self::$cache===NULL){self::$cache=(array)$outerCache->offsetGet('list');self::$timestamps=isset(self::$cache['*'])?self::$cache['*']:array();}if(!isset(self::$cache[$type])&&$file){self::$cache['*'][$file]=filemtime($file);self::parseScript($file);$outerCache->save('list',self::$cache);}if(isset(self::$cache[$type][$member])){$annotations=self::$cache[$type][$member];}else{$annotations=array();}}if($r
instanceof\ReflectionMethod&&!$r->isPrivate()&&(!$r->isConstructor()||!empty($annotations['inheritdoc'][0]))){try{$inherited=self::getAll(new\ReflectionMethod(get_parent_class($type),$member));}catch(\ReflectionException$e){try{$inherited=self::getAll($r->getPrototype());}catch(\ReflectionException$e){$inherited=array();}}$annotations+=array_intersect_key($inherited,array_flip(self::$inherited));}return
self::$cache[$type][$member]=$annotations;}private
static
function
parseComment($comment){static$tokens=array('true'=>TRUE,'false'=>FALSE,'null'=>NULL,''=>TRUE);$res=array();$comment=preg_replace('#^\s*\*\s?#ms','',trim($comment,'/*'));$parts=preg_split('#^\s*(?=@'.self::RE_IDENTIFIER.')#m',$comment,2);$description=trim($parts[0]);if($description!==''){$res['description']=array($description);}$matches=Strings::matchAll(isset($parts[1])?$parts[1]:'','~
				(?<=\s|^)@('.self::RE_IDENTIFIER.')[ \t]*      ##  annotation
				(
					\((?>'.self::RE_STRING.'|[^\'")@]+)+\)|  ##  (value)
					[^(@\r\n][^@\r\n]*|)                     ##  value
			~xi');foreach($matches
as$match){list(,$name,$value)=$match;if(substr($value,0,1)==='('){$items=array();$key='';$val=TRUE;$value[0]=',';while($m=Strings::match($value,'#\s*,\s*(?>('.self::RE_IDENTIFIER.')\s*=\s*)?('.self::RE_STRING.'|[^\'"),\s][^\'"),]*)#A')){$value=substr($value,strlen($m[0]));list(,$key,$val)=$m;$val=rtrim($val);if($val[0]==="'"||$val[0]==='"'){$val=substr($val,1,-1);}elseif(is_numeric($val)){$val=1*$val;}else{$lval=strtolower($val);$val=array_key_exists($lval,$tokens)?$tokens[$lval]:$val;}if($key===''){$items[]=$val;}else{$items[$key]=$val;}}$value=count($items)<2&&$key===''?$val:$items;}else{$value=trim($value);if(is_numeric($value)){$value=1*$value;}else{$lval=strtolower($value);$value=array_key_exists($lval,$tokens)?$tokens[$lval]:$value;}}$class=$name.'Annotation';if(class_exists($class)){$res[$name][]=new$class(is_array($value)?$value:array('value'=>$value));}else{$res[$name][]=is_array($value)?Nette\ArrayHash::from($value):$value;}}return$res;}private
static
function
parseScript($file){$s=file_get_contents($file);if(Strings::match($s,'#//nette'.'loader=(\S*)#')){return;}$expected=$namespace=$class=$docComment=NULL;$level=$classLevel=0;foreach(token_get_all($s)as$token){if(is_array($token)){switch($token[0]){case
T_DOC_COMMENT:$docComment=$token[1];case
T_WHITESPACE:case
T_COMMENT:continue
2;case
T_STRING:case
T_NS_SEPARATOR:case
T_VARIABLE:if($expected){$name.=$token[1];}continue
2;case
T_FUNCTION:case
T_VAR:case
T_PUBLIC:case
T_PROTECTED:case
T_NAMESPACE:case
T_CLASS:case
T_INTERFACE:$expected=$token[0];$name=NULL;continue
2;case
T_STATIC:case
T_ABSTRACT:case
T_FINAL:continue
2;case
T_CURLY_OPEN:case
T_DOLLAR_OPEN_CURLY_BRACES:$level++;}}if($expected){switch($expected){case
T_CLASS:case
T_INTERFACE:$class=$namespace.$name;$classLevel=$level;$name='';case
T_FUNCTION:if($token==='&'){continue
2;}case
T_VAR:case
T_PUBLIC:case
T_PROTECTED:if($class&&$name!==NULL&&$docComment){self::$cache[$class][$name]=self::parseComment($docComment);}break;case
T_NAMESPACE:$namespace=$name.'\\';}$expected=$docComment=NULL;}if($token===';'){$docComment=NULL;}elseif($token==='{'){$docComment=NULL;$level++;}elseif($token==='}'){$level--;if($level===$classLevel){$class=NULL;}}}}static
function
setCacheStorage(Nette\Caching\IStorage$storage){self::$cacheStorage=$storage;}static
function
getCacheStorage(){return
self::$cacheStorage;}}use
Nette\ObjectMixin;class
Extension
extends\ReflectionExtension{function
__toString(){return$this->getName();}function
getClasses(){$res=array();foreach(parent::getClassNames()as$val){$res[$val]=new
ClassType($val);}return$res;}function
getFunctions(){foreach($res=parent::getFunctions()as$key=>$val){$res[$key]=new
GlobalFunction($key);}return$res;}static
function
getReflection(){return
new
ClassType(get_called_class());}function
__call($name,$args){return
ObjectMixin::call($this,$name,$args);}function&__get($name){return
ObjectMixin::get($this,$name);}function
__set($name,$value){return
ObjectMixin::set($this,$name,$value);}function
__isset($name){return
ObjectMixin::has($this,$name);}function
__unset($name){ObjectMixin::remove($this,$name);}}class
GlobalFunction
extends\ReflectionFunction{private$value;function
__construct($name){parent::__construct($this->value=$name);}function
toCallback(){return
new
Nette\Callback($this->value);}function
__toString(){return$this->getName().'()';}function
getClosure(){return$this->isClosure()?$this->value:NULL;}function
getExtension(){return($name=$this->getExtensionName())?new
Extension($name):NULL;}function
getParameters(){foreach($res=parent::getParameters()as$key=>$val){$res[$key]=new
Parameter($this->value,$val->getName());}return$res;}static
function
getReflection(){return
new
ClassType(get_called_class());}function
__call($name,$args){return
ObjectMixin::call($this,$name,$args);}function&__get($name){return
ObjectMixin::get($this,$name);}function
__set($name,$value){return
ObjectMixin::set($this,$name,$value);}function
__isset($name){return
ObjectMixin::has($this,$name);}function
__unset($name){ObjectMixin::remove($this,$name);}}class
Method
extends\ReflectionMethod{static
function
from($class,$method){return
new
static(is_object($class)?get_class($class):$class,$method);}function
toCallback(){return
new
Nette\Callback(parent::getDeclaringClass()->getName(),$this->getName());}function
__toString(){return
parent::getDeclaringClass()->getName().'::'.$this->getName().'()';}function
getDeclaringClass(){return
new
ClassType(parent::getDeclaringClass()->getName());}function
getPrototype(){$prototype=parent::getPrototype();return
new
Method($prototype->getDeclaringClass()->getName(),$prototype->getName());}function
getExtension(){return($name=$this->getExtensionName())?new
Extension($name):NULL;}function
getParameters(){$me=array(parent::getDeclaringClass()->getName(),$this->getName());foreach($res=parent::getParameters()as$key=>$val){$res[$key]=new
Parameter($me,$val->getName());}return$res;}function
hasAnnotation($name){$res=AnnotationsParser::getAll($this);return!empty($res[$name]);}function
getAnnotation($name){$res=AnnotationsParser::getAll($this);return
isset($res[$name])?end($res[$name]):NULL;}function
getAnnotations(){return
AnnotationsParser::getAll($this);}function
getDescription(){return$this->getAnnotation('description');}static
function
getReflection(){return
new
ClassType(get_called_class());}function
__call($name,$args){return
ObjectMixin::call($this,$name,$args);}function&__get($name){return
ObjectMixin::get($this,$name);}function
__set($name,$value){return
ObjectMixin::set($this,$name,$value);}function
__isset($name){return
ObjectMixin::has($this,$name);}function
__unset($name){ObjectMixin::remove($this,$name);}}class
Parameter
extends\ReflectionParameter{private$function;function
__construct($function,$parameter){parent::__construct($this->function=$function,$parameter);}function
getClass(){return($ref=parent::getClass())?new
ClassType($ref->getName()):NULL;}function
getClassName(){try{return($ref=parent::getClass())?$ref->getName():NULL;}catch(\ReflectionException$e){if(preg_match('#Class (.+) does not exist#',$e->getMessage(),$m)){return$m[1];}throw$e;}}function
getDeclaringClass(){return($ref=parent::getDeclaringClass())?new
ClassType($ref->getName()):NULL;}function
getDeclaringFunction(){return
is_array($this->function)?new
Method($this->function[0],$this->function[1]):new
GlobalFunction($this->function);}function
isDefaultValueAvailable(){if(PHP_VERSION_ID===50316){try{$this->getDefaultValue();return
TRUE;}catch(\ReflectionException$e){return
FALSE;}}return
parent::isDefaultValueAvailable();}function
__toString(){return'$'.parent::getName().' in '.$this->getDeclaringFunction();}static
function
getReflection(){return
new
ClassType(get_called_class());}function
__call($name,$args){return
ObjectMixin::call($this,$name,$args);}function&__get($name){return
ObjectMixin::get($this,$name);}function
__set($name,$value){return
ObjectMixin::set($this,$name,$value);}function
__isset($name){return
ObjectMixin::has($this,$name);}function
__unset($name){ObjectMixin::remove($this,$name);}}class
Property
extends\ReflectionProperty{function
__toString(){return
parent::getDeclaringClass()->getName().'::$'.$this->getName();}function
getDeclaringClass(){return
new
ClassType(parent::getDeclaringClass()->getName());}function
hasAnnotation($name){$res=AnnotationsParser::getAll($this);return!empty($res[$name]);}function
getAnnotation($name){$res=AnnotationsParser::getAll($this);return
isset($res[$name])?end($res[$name]):NULL;}function
getAnnotations(){return
AnnotationsParser::getAll($this);}function
getDescription(){return$this->getAnnotation('description');}static
function
getReflection(){return
new
ClassType(get_called_class());}function
__call($name,$args){return
ObjectMixin::call($this,$name,$args);}function&__get($name){return
ObjectMixin::get($this,$name);}function
__set($name,$value){return
ObjectMixin::set($this,$name,$value);}function
__isset($name){return
ObjectMixin::has($this,$name);}function
__unset($name){ObjectMixin::remove($this,$name);}}}namespace Nette\Security{use
Nette;class
AuthenticationException
extends\Exception{}}namespace Nette\Security\Diagnostics{use
Nette;class
UserPanel
extends
Nette\Object
implements
Nette\Diagnostics\IBarPanel{private$user;function
__construct(Nette\Security\User$user){$this->user=$user;}function
getTab(){ob_start();?>
<?php if($this->user->isLoggedIn()):?>
<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAJkSURBVDjLhVLPSxRhGH5mf8yOs9O6aa2b6BJhsW3RilAXDSW65clDdgwkEBH/gIiI6FC3uoRBQYeooP4Aw9isQ2xG5YZEVFrINmnFto67s7sz33xf76wedEfwgxdm4H1+vO/zSkIINL7Bax/PpxLRkXhUTVuMY/7Hci4z++2e/njofmNvYDvwqe726/2pcJsa9MMhgd7D4T5NUQ8GBibBZka3kPgaCZKk7IKbVT8qNodpcUToe6g33tadOjCyo4NYREkrpGyYHLYDMEfArHFoioTE/o70jgRVC3AIZDMqLogA9fKR12qVefblGWHui54rmDZCsoSaLVClUkMSVlYZZl7P53YkyGQ/T9+dWqoaFY6K5ZaDEo1w42GOVWaz7xv7pc0x9kxkh/uOxa6c6JSSnDz/MgJgFGM0ZCLALTzKrhZePnh1S+gXr3p2cHQ0kx7oSVwePtmWbNUCKFsCKb6+i3K1GXKQY2JfrCW/XJqQfGNvBL/9bMsILRF1/MzxWGo3RfbHoK3VjUkgDlhEsqDXEKJ0Lgx2tSJ56JJnB13tLf3NYR9+F20CCwJSuSnw9W8hJHxdMtHeqiAYix/xEGia0ilLPuRXKnVVx41vYwRG6XEOGGsMst8PWVF3eXZgWUyixChvCc6GMiNwja7RJjR3x3GLRFwyj4PFvPFzQTehNUn1f4e6LIfXCdxDovGR2BvEh+9lVArFNQ/BdCY/Pjq5eGfqbQGC1IPkpEkGwnREMvl09/DkxQpuPs0beDd3ets7cF/HuefL8ViU7YnIYbpcTS+Y0P9apXLe+IeSWRSfzvZs7v8PV6U0ly704DwAAAAASUVORK5CYII=" style="margin-right:0" />&nbsp;
<?php else:?>
<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAQAAAC1+jfqAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAE4SURBVCjPZdBLSwIBGIXh/lHQb4guyza1CEIqpNoIQdHKXEQQrkS6IUSLFhYFtpCIwUAG07IstTTnqjNTjnSRZmPg4m3lpYZvd84DB74BBjq36zkXk07CORB9nl7aVydtkwZ1NKL2tMcFYqLJOxYGb1QIiC5w5dhYGOgo6EQcFxCcOjV0VCRUdtxgX1R4RaZClTzz7okF/2FLo0SRChvtkdA/sDl1Wk6RQuASAYHg54S/D6wPnjzrNLAwqVJBJsfax/BoFwQjZWw0LEx0SmQocsGk2AVHko6MhoGByhMZEqSZ++qCs5bBLSo1qkgUSBMny1K7C45/qtwho6NQ4oFr4mRZ7IGwmqWAjMILee65IUWMmd6Ed3xlL4qEjkqZR9KE8X2PDf151Kq9ZW03Q+1Ae7np1WZznfwXGfNkzblrzUIAAAAASUVORK5CYII=" style="margin-right:0" />&nbsp;
<?php endif?>
<?php
return
ob_get_clean();}function
getPanel(){ob_start();?>
<div class="nette-UserPanel">
	<h1><?php if($this->user->isLoggedIn()):?>Logged in<?php else:?>Unlogged<?php endif?></h1>

	<?php if($this->user->getIdentity()):echo
Nette\Diagnostics\Dumper::toHtml($this->user->getIdentity());else:?><p>no identity</p><?php endif?>
</div>
<?php
return
ob_get_clean();}}}namespace Nette\Security{use
Nette;class
Identity
extends
Nette\Object
implements
IIdentity{private$id;private$roles;private$data;function
__construct($id,$roles=NULL,$data=NULL){$this->setId($id);$this->setRoles((array)$roles);$this->data=$data
instanceof\Traversable?iterator_to_array($data):(array)$data;}function
setId($id){$this->id=is_numeric($id)?1*$id:$id;return$this;}function
getId(){return$this->id;}function
setRoles(array$roles){$this->roles=$roles;return$this;}function
getRoles(){return$this->roles;}function
getData(){return$this->data;}function
__set($key,$value){if(parent::__isset($key)){parent::__set($key,$value);}else{$this->data[$key]=$value;}}function&__get($key){if(parent::__isset($key)){return
parent::__get($key);}else{return$this->data[$key];}}function
__isset($key){return
isset($this->data[$key])||parent::__isset($key);}function
__unset($name){Nette\ObjectMixin::remove($this,$name);}}class
Permission
extends
Nette\Object
implements
IAuthorizator{private$roles=array();private$resources=array();private$rules=array('allResources'=>array('allRoles'=>array('allPrivileges'=>array('type'=>self::DENY,'assert'=>NULL),'byPrivilege'=>array()),'byRole'=>array()),'byResource'=>array());private$queriedRole,$queriedResource;function
addRole($role,$parents=NULL){$this->checkRole($role,FALSE);if(isset($this->roles[$role])){throw
new
Nette\InvalidStateException("Role '$role' already exists in the list.");}$roleParents=array();if($parents!==NULL){if(!is_array($parents)){$parents=array($parents);}foreach($parents
as$parent){$this->checkRole($parent);$roleParents[$parent]=TRUE;$this->roles[$parent]['children'][$role]=TRUE;}}$this->roles[$role]=array('parents'=>$roleParents,'children'=>array());return$this;}function
hasRole($role){$this->checkRole($role,FALSE);return
isset($this->roles[$role]);}private
function
checkRole($role,$need=TRUE){if(!is_string($role)||$role===''){throw
new
Nette\InvalidArgumentException("Role must be a non-empty string.");}elseif($need&&!isset($this->roles[$role])){throw
new
Nette\InvalidStateException("Role '$role' does not exist.");}}function
getRoles(){return
array_keys($this->roles);}function
getRoleParents($role){$this->checkRole($role);return
array_keys($this->roles[$role]['parents']);}function
roleInheritsFrom($role,$inherit,$onlyParents=FALSE){$this->checkRole($role);$this->checkRole($inherit);$inherits=isset($this->roles[$role]['parents'][$inherit]);if($inherits||$onlyParents){return$inherits;}foreach($this->roles[$role]['parents']as$parent=>$foo){if($this->roleInheritsFrom($parent,$inherit)){return
TRUE;}}return
FALSE;}function
removeRole($role){$this->checkRole($role);foreach($this->roles[$role]['children']as$child=>$foo){unset($this->roles[$child]['parents'][$role]);}foreach($this->roles[$role]['parents']as$parent=>$foo){unset($this->roles[$parent]['children'][$role]);}unset($this->roles[$role]);foreach($this->rules['allResources']['byRole']as$roleCurrent=>$rules){if($role===$roleCurrent){unset($this->rules['allResources']['byRole'][$roleCurrent]);}}foreach($this->rules['byResource']as$resourceCurrent=>$visitor){if(isset($visitor['byRole'])){foreach($visitor['byRole']as$roleCurrent=>$rules){if($role===$roleCurrent){unset($this->rules['byResource'][$resourceCurrent]['byRole'][$roleCurrent]);}}}}return$this;}function
removeAllRoles(){$this->roles=array();foreach($this->rules['allResources']['byRole']as$roleCurrent=>$rules){unset($this->rules['allResources']['byRole'][$roleCurrent]);}foreach($this->rules['byResource']as$resourceCurrent=>$visitor){foreach($visitor['byRole']as$roleCurrent=>$rules){unset($this->rules['byResource'][$resourceCurrent]['byRole'][$roleCurrent]);}}return$this;}function
addResource($resource,$parent=NULL){$this->checkResource($resource,FALSE);if(isset($this->resources[$resource])){throw
new
Nette\InvalidStateException("Resource '$resource' already exists in the list.");}if($parent!==NULL){$this->checkResource($parent);$this->resources[$parent]['children'][$resource]=TRUE;}$this->resources[$resource]=array('parent'=>$parent,'children'=>array());return$this;}function
hasResource($resource){$this->checkResource($resource,FALSE);return
isset($this->resources[$resource]);}private
function
checkResource($resource,$need=TRUE){if(!is_string($resource)||$resource===''){throw
new
Nette\InvalidArgumentException("Resource must be a non-empty string.");}elseif($need&&!isset($this->resources[$resource])){throw
new
Nette\InvalidStateException("Resource '$resource' does not exist.");}}function
getResources(){return
array_keys($this->resources);}function
resourceInheritsFrom($resource,$inherit,$onlyParent=FALSE){$this->checkResource($resource);$this->checkResource($inherit);if($this->resources[$resource]['parent']===NULL){return
FALSE;}$parent=$this->resources[$resource]['parent'];if($inherit===$parent){return
TRUE;}elseif($onlyParent){return
FALSE;}while($this->resources[$parent]['parent']!==NULL){$parent=$this->resources[$parent]['parent'];if($inherit===$parent){return
TRUE;}}return
FALSE;}function
removeResource($resource){$this->checkResource($resource);$parent=$this->resources[$resource]['parent'];if($parent!==NULL){unset($this->resources[$parent]['children'][$resource]);}$removed=array($resource);foreach($this->resources[$resource]['children']as$child=>$foo){$this->removeResource($child);$removed[]=$child;}foreach($removed
as$resourceRemoved){foreach($this->rules['byResource']as$resourceCurrent=>$rules){if($resourceRemoved===$resourceCurrent){unset($this->rules['byResource'][$resourceCurrent]);}}}unset($this->resources[$resource]);return$this;}function
removeAllResources(){foreach($this->resources
as$resource=>$foo){foreach($this->rules['byResource']as$resourceCurrent=>$rules){if($resource===$resourceCurrent){unset($this->rules['byResource'][$resourceCurrent]);}}}$this->resources=array();return$this;}function
allow($roles=self::ALL,$resources=self::ALL,$privileges=self::ALL,$assertion=NULL){$this->setRule(TRUE,self::ALLOW,$roles,$resources,$privileges,$assertion);return$this;}function
deny($roles=self::ALL,$resources=self::ALL,$privileges=self::ALL,$assertion=NULL){$this->setRule(TRUE,self::DENY,$roles,$resources,$privileges,$assertion);return$this;}function
removeAllow($roles=self::ALL,$resources=self::ALL,$privileges=self::ALL){$this->setRule(FALSE,self::ALLOW,$roles,$resources,$privileges);return$this;}function
removeDeny($roles=self::ALL,$resources=self::ALL,$privileges=self::ALL){$this->setRule(FALSE,self::DENY,$roles,$resources,$privileges);return$this;}protected
function
setRule($toAdd,$type,$roles,$resources,$privileges,$assertion=NULL){if($roles===self::ALL){$roles=array(self::ALL);}else{if(!is_array($roles)){$roles=array($roles);}foreach($roles
as$role){$this->checkRole($role);}}if($resources===self::ALL){$resources=array(self::ALL);}else{if(!is_array($resources)){$resources=array($resources);}foreach($resources
as$resource){$this->checkResource($resource);}}if($privileges===self::ALL){$privileges=array();}elseif(!is_array($privileges)){$privileges=array($privileges);}if($toAdd){foreach($resources
as$resource){foreach($roles
as$role){$rules=&$this->getRules($resource,$role,TRUE);if(count($privileges)===0){$rules['allPrivileges']['type']=$type;$rules['allPrivileges']['assert']=$assertion;if(!isset($rules['byPrivilege'])){$rules['byPrivilege']=array();}}else{foreach($privileges
as$privilege){$rules['byPrivilege'][$privilege]['type']=$type;$rules['byPrivilege'][$privilege]['assert']=$assertion;}}}}}else{foreach($resources
as$resource){foreach($roles
as$role){$rules=&$this->getRules($resource,$role);if($rules===NULL){continue;}if(count($privileges)===0){if($resource===self::ALL&&$role===self::ALL){if($type===$rules['allPrivileges']['type']){$rules=array('allPrivileges'=>array('type'=>self::DENY,'assert'=>NULL),'byPrivilege'=>array());}continue;}if($type===$rules['allPrivileges']['type']){unset($rules['allPrivileges']);}}else{foreach($privileges
as$privilege){if(isset($rules['byPrivilege'][$privilege])&&$type===$rules['byPrivilege'][$privilege]['type']){unset($rules['byPrivilege'][$privilege]);}}}}}}return$this;}function
isAllowed($role=self::ALL,$resource=self::ALL,$privilege=self::ALL){$this->queriedRole=$role;if($role!==self::ALL){if($role
instanceof
IRole){$role=$role->getRoleId();}$this->checkRole($role);}$this->queriedResource=$resource;if($resource!==self::ALL){if($resource
instanceof
IResource){$resource=$resource->getResourceId();}$this->checkResource($resource);}do{if($role!==NULL&&NULL!==($result=$this->searchRolePrivileges($privilege===self::ALL,$role,$resource,$privilege))){break;}if($privilege===self::ALL){if($rules=$this->getRules($resource,self::ALL)){foreach($rules['byPrivilege']as$privilege=>$rule){if(self::DENY===($result=$this->getRuleType($resource,NULL,$privilege))){break
2;}}if(NULL!==($result=$this->getRuleType($resource,NULL,NULL))){break;}}}else{if(NULL!==($result=$this->getRuleType($resource,NULL,$privilege))){break;}elseif(NULL!==($result=$this->getRuleType($resource,NULL,NULL))){break;}}$resource=$this->resources[$resource]['parent'];}while(TRUE);$this->queriedRole=$this->queriedResource=NULL;return$result;}function
getQueriedRole(){return$this->queriedRole;}function
getQueriedResource(){return$this->queriedResource;}private
function
searchRolePrivileges($all,$role,$resource,$privilege){$dfs=array('visited'=>array(),'stack'=>array($role));while(NULL!==($role=array_pop($dfs['stack']))){if(isset($dfs['visited'][$role])){continue;}if($all){if($rules=$this->getRules($resource,$role)){foreach($rules['byPrivilege']as$privilege2=>$rule){if(self::DENY===$this->getRuleType($resource,$role,$privilege2)){return
self::DENY;}}if(NULL!==($type=$this->getRuleType($resource,$role,NULL))){return$type;}}}else{if(NULL!==($type=$this->getRuleType($resource,$role,$privilege))){return$type;}elseif(NULL!==($type=$this->getRuleType($resource,$role,NULL))){return$type;}}$dfs['visited'][$role]=TRUE;foreach($this->roles[$role]['parents']as$roleParent=>$foo){$dfs['stack'][]=$roleParent;}}return
NULL;}private
function
getRuleType($resource,$role,$privilege){if(!$rules=$this->getRules($resource,$role)){return
NULL;}if($privilege===self::ALL){if(isset($rules['allPrivileges'])){$rule=$rules['allPrivileges'];}else{return
NULL;}}elseif(!isset($rules['byPrivilege'][$privilege])){return
NULL;}else{$rule=$rules['byPrivilege'][$privilege];}if($rule['assert']===NULL||Nette\Utils\Callback::invoke($rule['assert'],$this,$role,$resource,$privilege)){return$rule['type'];}elseif($resource!==self::ALL||$role!==self::ALL||$privilege!==self::ALL){return
NULL;}elseif(self::ALLOW===$rule['type']){return
self::DENY;}else{return
self::ALLOW;}}private
function&getRules($resource,$role,$create=FALSE){$null=NULL;if($resource===self::ALL){$visitor=&$this->rules['allResources'];}else{if(!isset($this->rules['byResource'][$resource])){if(!$create){return$null;}$this->rules['byResource'][$resource]=array();}$visitor=&$this->rules['byResource'][$resource];}if($role===self::ALL){if(!isset($visitor['allRoles'])){if(!$create){return$null;}$visitor['allRoles']['byPrivilege']=array();}return$visitor['allRoles'];}if(!isset($visitor['byRole'][$role])){if(!$create){return$null;}$visitor['byRole'][$role]['byPrivilege']=array();}return$visitor['byRole'][$role];}}class
SimpleAuthenticator
extends
Nette\Object
implements
IAuthenticator{private$userlist;function
__construct(array$userlist){$this->userlist=$userlist;}function
authenticate(array$credentials){list($username,$password)=$credentials;foreach($this->userlist
as$name=>$pass){if(strcasecmp($name,$username)===0){if((string)$pass===(string)$password){return
new
Identity($name);}else{throw
new
AuthenticationException("Invalid password.",self::INVALID_CREDENTIAL);}}}throw
new
AuthenticationException("User '$username' not found.",self::IDENTITY_NOT_FOUND);}}class
User
extends
Nette\Object{const
MANUAL=IUserStorage::MANUAL,INACTIVITY=IUserStorage::INACTIVITY,BROWSER_CLOSED=IUserStorage::BROWSER_CLOSED;public$guestRole='guest';public$authenticatedRole='authenticated';public$onLoggedIn;public$onLoggedOut;private$storage;private$authenticator;private$authorizator;function
__construct(IUserStorage$storage,IAuthenticator$authenticator=NULL,IAuthorizator$authorizator=NULL){$this->storage=$storage;$this->authenticator=$authenticator;$this->authorizator=$authorizator;}final
function
getStorage(){return$this->storage;}function
login($id=NULL,$password=NULL){$this->logout(TRUE);if(!$id
instanceof
IIdentity){$id=$this->getAuthenticator()->authenticate(func_get_args());}$this->storage->setIdentity($id);$this->storage->setAuthenticated(TRUE);$this->onLoggedIn($this);}final
function
logout($clearIdentity=FALSE){if($this->isLoggedIn()){$this->onLoggedOut($this);$this->storage->setAuthenticated(FALSE);}if($clearIdentity){$this->storage->setIdentity(NULL);}}final
function
isLoggedIn(){return$this->storage->isAuthenticated();}final
function
getIdentity(){return$this->storage->getIdentity();}function
getId(){$identity=$this->getIdentity();return$identity?$identity->getId():NULL;}function
setAuthenticator(IAuthenticator$handler){$this->authenticator=$handler;return$this;}final
function
getAuthenticator($need=TRUE){if($need&&!$this->authenticator){throw
new
Nette\InvalidStateException('Authenticator has not been set.');}return$this->authenticator;}function
setExpiration($time,$whenBrowserIsClosed=TRUE,$clearIdentity=FALSE){$flags=($whenBrowserIsClosed?IUserStorage::BROWSER_CLOSED:0)|($clearIdentity?IUserStorage::CLEAR_IDENTITY:0);$this->storage->setExpiration($time,$flags);return$this;}final
function
getLogoutReason(){return$this->storage->getLogoutReason();}function
getRoles(){if(!$this->isLoggedIn()){return
array($this->guestRole);}$identity=$this->getIdentity();return$identity&&$identity->getRoles()?$identity->getRoles():array($this->authenticatedRole);}final
function
isInRole($role){return
in_array($role,$this->getRoles(),TRUE);}function
isAllowed($resource=IAuthorizator::ALL,$privilege=IAuthorizator::ALL){foreach($this->getRoles()as$role){if($this->getAuthorizator()->isAllowed($role,$resource,$privilege)){return
TRUE;}}return
FALSE;}function
setAuthorizator(IAuthorizator$handler){$this->authorizator=$handler;return$this;}final
function
getAuthorizator($need=TRUE){if($need&&!$this->authorizator){throw
new
Nette\InvalidStateException('Authorizator has not been set.');}return$this->authorizator;}}}namespace Nette\Templating{use
Nette;use
Nette\Caching;use
Nette\Utils\Callback;class
Template
extends
Nette\Object
implements
ITemplate{public$onPrepareFilters=array();private$source;private$params=array();private$filters=array();private$helpers=array();private$helperLoaders=array();private$cacheStorage;function
setSource($source){$this->source=$source;return$this;}function
getSource(){return$this->source;}function
render(){$cache=new
Caching\Cache($storage=$this->getCacheStorage(),'Nette.Template');$cached=$compiled=$cache->load($this->source);if($compiled===NULL){$compiled=$this->compile();$cache->save($this->source,$compiled,array(Caching\Cache::CONSTS=>'Nette\Framework::REVISION'));$cached=$cache->load($this->source);}if($cached!==NULL&&$storage
instanceof
Caching\Storages\PhpFileStorage){Nette\Utils\LimitedScope::load($cached['file'],$this->getParameters());}else{Nette\Utils\LimitedScope::evaluate($compiled,$this->getParameters());}}function
save($file){if(file_put_contents($file,$this->__toString(TRUE))===FALSE){throw
new
Nette\IOException("Unable to save file '$file'.");}}function
__toString(){ob_start();try{$this->render();return
ob_get_clean();}catch(\Exception$e){ob_end_clean();if(func_get_args()&&func_get_arg(0)){throw$e;}else{trigger_error("Exception in ".__METHOD__."(): {$e->getMessage()} in {$e->getFile()}:{$e->getLine()}",E_USER_ERROR);}}}function
compile(){if(!$this->filters){$this->onPrepareFilters($this);}$code=$this->getSource();foreach($this->filters
as$filter){$code=self::extractPhp($code,$blocks);$code=call_user_func($filter,$code);$code=strtr($code,$blocks);}return
Helpers::optimizePhp($code);}function
registerFilter($callback){$this->filters[]=Callback::check($callback);return$this;}final
function
getFilters(){return$this->filters;}function
registerHelper($name,$callback){$this->helpers[strtolower($name)]=$callback;return$this;}function
registerHelperLoader($callback){array_unshift($this->helperLoaders,$callback);return$this;}final
function
getHelpers(){return$this->helpers;}final
function
getHelperLoaders(){return$this->helperLoaders;}function
__call($name,$args){$lname=strtolower($name);if(!isset($this->helpers[$lname])){foreach($this->helperLoaders
as$loader){$helper=Callback::invoke($loader,$lname);if($helper){$this->registerHelper($lname,$helper);return
Callback::invokeArgs($this->helpers[$lname],$args);}}return
parent::__call($name,$args);}return
Callback::invokeArgs($this->helpers[$lname],$args);}function
setTranslator(Nette\Localization\ITranslator$translator=NULL){$this->registerHelper('translate',$translator===NULL?NULL:array($translator,'translate'));return$this;}function
add($name,$value){if(array_key_exists($name,$this->params)){throw
new
Nette\InvalidStateException("The variable '$name' already exists.");}$this->params[$name]=$value;return$this;}function
setParameters(array$params){$this->params=$params+$this->params;return$this;}function
getParameters(){$this->params['template']=$this;return$this->params;}function
__set($name,$value){$this->params[$name]=$value;}function&__get($name){if(!array_key_exists($name,$this->params)){trigger_error("The variable '$name' does not exist in template.",E_USER_NOTICE);}return$this->params[$name];}function
__isset($name){return
isset($this->params[$name]);}function
__unset($name){unset($this->params[$name]);}function
setCacheStorage(Caching\IStorage$storage){$this->cacheStorage=$storage;return$this;}function
getCacheStorage(){if($this->cacheStorage===NULL){return
new
Caching\Storages\DevNullStorage;}return$this->cacheStorage;}private
static
function
extractPhp($source,&$blocks){$res='';$blocks=array();$tokens=token_get_all($source);foreach($tokens
as$n=>$token){if(is_array($token)){if($token[0]===T_INLINE_HTML){$res.=$token[1];continue;}elseif($token[0]===T_CLOSE_TAG){if($php!==$res){$res.=str_repeat("\n",substr_count($php,"\n"));}$res.=$token[1];continue;}elseif($token[0]===T_OPEN_TAG&&$token[1]==='<?'&&isset($tokens[$n+1][1])&&$tokens[$n+1][1]==='xml'){$php=&$res;$token[1]='<<?php ?>?';}elseif($token[0]===T_OPEN_TAG||$token[0]===T_OPEN_TAG_WITH_ECHO){$res.=$id="<?php \x01@php:p".count($blocks)."@\x02";$php=&$blocks[$id];}$php.=$token[1];}else{$php.=$token;}}return$res;}}class
FileTemplate
extends
Template
implements
IFileTemplate{private$file;function
__construct($file=NULL){if($file!==NULL){$this->setFile($file);}}function
setFile($file){$this->file=realpath($file);if(!$this->file){throw
new
Nette\FileNotFoundException("Missing template file '$file'.");}return$this;}function
getFile(){return$this->file;}function
getSource(){return
file_get_contents($this->file);}function
render(){if($this->file==NULL){throw
new
Nette\InvalidStateException("Template file name was not specified.");}$cache=new
Caching\Cache($storage=$this->getCacheStorage(),'Nette.FileTemplate');if($storage
instanceof
Caching\Storages\PhpFileStorage){$storage->hint=str_replace(dirname(dirname($this->file)),'',$this->file);}$cached=$compiled=$cache->load($this->file);if($compiled===NULL){try{$compiled="<?php\n\n// source file: $this->file\n\n?>".$this->compile();}catch(FilterException$e){$e->setSourceFile($this->file);throw$e;}$cache->save($this->file,$compiled,array(Caching\Cache::FILES=>$this->file,Caching\Cache::CONSTS=>'Nette\Framework::REVISION'));$cached=$cache->load($this->file);}if($cached!==NULL&&$storage
instanceof
Caching\Storages\PhpFileStorage){Nette\Utils\LimitedScope::load($cached['file'],$this->getParameters());}else{Nette\Utils\LimitedScope::evaluate($compiled,$this->getParameters());}}}use
Nette\Utils\Strings;use
Nette\Forms\Form;use
Nette\Utils\Html;final
class
Helpers{private
static$helpers=array('normalize'=>'Nette\Utils\Strings::normalize','toascii'=>'Nette\Utils\Strings::toAscii','webalize'=>'Nette\Utils\Strings::webalize','truncate'=>'Nette\Utils\Strings::truncate','lower'=>'Nette\Utils\Strings::lower','upper'=>'Nette\Utils\Strings::upper','firstupper'=>'Nette\Utils\Strings::firstUpper','capitalize'=>'Nette\Utils\Strings::capitalize','trim'=>'Nette\Utils\Strings::trim','padleft'=>'Nette\Utils\Strings::padLeft','padright'=>'Nette\Utils\Strings::padRight','reverse'=>'Nette\Utils\Strings::reverse','replacere'=>'Nette\Utils\Strings::replace','url'=>'rawurlencode','striptags'=>'strip_tags','substr'=>'Nette\Utils\Strings::substring','repeat'=>'str_repeat','implode'=>'implode','number'=>'number_format');public
static$dateFormat='%x';static
function
loader($helper){if(method_exists(__CLASS__,$helper)){return
array(__CLASS__,$helper);}elseif(isset(self::$helpers[$helper])){return
self::$helpers[$helper];}}static
function
escapeHtml($s,$quotes=ENT_QUOTES){if(is_object($s)&&($s
instanceof
ITemplate||$s
instanceof
Html||$s
instanceof
Form)){return$s->__toString(TRUE);}return
htmlSpecialChars($s,$quotes);}static
function
escapeHtmlComment($s){return' '.str_replace('-','- ',$s);}static
function
escapeXML($s){return
htmlSpecialChars(preg_replace('#[\x00-\x08\x0B\x0C\x0E-\x1F]+#','',$s),ENT_QUOTES);}static
function
escapeCss($s){return
addcslashes($s,"\x00..\x1F!\"#$%&'()*+,./:;<=>?@[\\]^`{|}~");}static
function
escapeJs($s){if(is_object($s)&&($s
instanceof
ITemplate||$s
instanceof
Html||$s
instanceof
Form)){$s=$s->__toString(TRUE);}return
str_replace(']]>',']]\x3E',Nette\Utils\Json::encode($s));}static
function
escapeICal($s){return
addcslashes(preg_replace('#[\x00-\x08\x0B\x0C-\x1F]+#','',$s),"\";\\,:\n");}static
function
strip($s){return
Strings::replace($s,'#(</textarea|</pre|</script|^).*?(?=<textarea|<pre|<script|\z)#si',function($m){return
trim(preg_replace('#[ \t\r\n]+#'," ",$m[0]));});}static
function
indent($s,$level=1,$chars="\t"){if($level>=1){$s=Strings::replace($s,'#<(textarea|pre).*?</\\1#si',function($m){return
strtr($m[0]," \t\r\n","\x1F\x1E\x1D\x1A");});$s=Strings::indent($s,$level,$chars);$s=strtr($s,"\x1F\x1E\x1D\x1A"," \t\r\n");}return$s;}static
function
date($time,$format=NULL){if($time==NULL){return
NULL;}if(!isset($format)){$format=self::$dateFormat;}$time=Nette\DateTime::from($time);return
Strings::contains($format,'%')?strftime($format,$time->format('U')):$time->format($format);}static
function
modifyDate($time,$delta,$unit=NULL){return$time==NULL?NULL:Nette\DateTime::from($time)->modify($delta.$unit);}static
function
bytes($bytes,$precision=2){$bytes=round($bytes);$units=array('B','kB','MB','GB','TB','PB');foreach($units
as$unit){if(abs($bytes)<1024||$unit===end($units)){break;}$bytes=$bytes/1024;}return
round($bytes,$precision).' '.$unit;}static
function
length($var){return
is_string($var)?Strings::length($var):count($var);}static
function
replace($subject,$search,$replacement=''){return
str_replace($search,$replacement,$subject);}static
function
dataStream($data,$type=NULL){if($type===NULL){$type=Nette\Utils\MimeTypeDetector::fromString($data);}return'data:'.($type?"$type;":'').'base64,'.base64_encode($data);}static
function
null($value){return'';}static
function
nl2br($value){return
nl2br($value,Html::$xhtml);}static
function
optimizePhp($source,$lineLength=80,$existenceOfThisParameterSolvesDamnBugInPHP535=NULL){$res=$php='';$lastChar=';';$tokens=new\ArrayIterator(token_get_all($source));foreach($tokens
as$key=>$token){if(is_array($token)){if($token[0]===T_INLINE_HTML){$lastChar='';$res.=$token[1];}elseif($token[0]===T_CLOSE_TAG){$next=isset($tokens[$key+1])?$tokens[$key+1]:NULL;if(substr($res,-1)!=='<'&&preg_match('#^<\?php\s*\z#',$php)){$php='';}elseif(is_array($next)&&$next[0]===T_OPEN_TAG){if(!strspn($lastChar,';{}:/')){$php.=$lastChar=';';}if(substr($next[1],-1)==="\n"){$php.="\n";}$tokens->next();}elseif($next){$res.=preg_replace('#;?(\s)*\z#','$1',$php).$token[1];if(strlen($res)-strrpos($res,"\n")>$lineLength&&(!is_array($next)||strpos($next[1],"\n")===FALSE)){$res.="\n";}$php='';}else{if(!strspn($lastChar,'};')){$php.=';';}}}elseif($token[0]===T_ELSE||$token[0]===T_ELSEIF){if($tokens[$key+1]===':'&&$lastChar==='}'){$php.=';';}$lastChar='';$php.=$token[1];}else{if(!in_array($token[0],array(T_WHITESPACE,T_COMMENT,T_DOC_COMMENT,T_OPEN_TAG))){$lastChar='';}$php.=$token[1];}}else{$php.=$lastChar=$token;}}return$res.$php;}}}namespace Nette\Utils{use
Nette;final
class
Arrays{final
function
__construct(){throw
new
Nette\StaticClassException;}static
function
get(array$arr,$key,$default=NULL){foreach(is_array($key)?$key:array($key)as$k){if(is_array($arr)&&array_key_exists($k,$arr)){$arr=$arr[$k];}else{if(func_num_args()<3){throw
new
Nette\InvalidArgumentException("Missing item '$k'.");}return$default;}}return$arr;}static
function&getRef(&$arr,$key){foreach(is_array($key)?$key:array($key)as$k){if(is_array($arr)||$arr===NULL){$arr=&$arr[$k];}else{throw
new
Nette\InvalidArgumentException('Traversed item is not an array.');}}return$arr;}static
function
mergeTree($arr1,$arr2){$res=$arr1+$arr2;foreach(array_intersect_key($arr1,$arr2)as$k=>$v){if(is_array($v)&&is_array($arr2[$k])){$res[$k]=self::mergeTree($v,$arr2[$k]);}}return$res;}static
function
searchKey($arr,$key){$foo=array($key=>NULL);return
array_search(key($foo),array_keys($arr),TRUE);}static
function
insertBefore(array&$arr,$key,array$inserted){$offset=self::searchKey($arr,$key);$arr=array_slice($arr,0,$offset,TRUE)+$inserted+array_slice($arr,$offset,count($arr),TRUE);}static
function
insertAfter(array&$arr,$key,array$inserted){$offset=self::searchKey($arr,$key);$offset=$offset===FALSE?count($arr):$offset+1;$arr=array_slice($arr,0,$offset,TRUE)+$inserted+array_slice($arr,$offset,count($arr),TRUE);}static
function
renameKey(array&$arr,$oldKey,$newKey){$offset=self::searchKey($arr,$oldKey);if($offset!==FALSE){$keys=array_keys($arr);$keys[$offset]=$newKey;$arr=array_combine($keys,$arr);}}static
function
grep(array$arr,$pattern,$flags=0){set_error_handler(function($severity,$message)use($pattern){restore_error_handler();throw
new
RegexpException("$message in pattern: $pattern");});$res=preg_grep($pattern,$arr,$flags);restore_error_handler();if(preg_last_error()){throw
new
RegexpException(NULL,preg_last_error(),$pattern);}return$res;}static
function
flatten(array$arr){$res=array();array_walk_recursive($arr,function($a)use(&$res){$res[]=$a;});return$res;}static
function
isList($value){return
is_array($value)&&(!$value||array_keys($value)===range(0,count($value)-1));}}final
class
Callback{static
function
closure($callable,$m=NULL){if($m!==NULL){$callable=array($callable,$m);}elseif($callable
instanceof\Closure){return$callable;}self::check($callable,TRUE);$_callable_=$callable;return
function()use($_callable_){Callback::check($_callable_);return
call_user_func_array($_callable_,func_get_args());};}static
function
invoke($callable){self::check($callable);return
call_user_func_array($callable,array_slice(func_get_args(),1));}static
function
invokeArgs($callable,array$args=array()){self::check($callable);return
call_user_func_array($callable,$args);}static
function
check($callable,$syntax=FALSE){if(!is_callable($callable,$syntax)){throw
new
Nette\InvalidArgumentException($syntax?'Given value is not a callable type.':"Callback '".self::toString($callable)."' is not callable.");}return$callable;}static
function
toString($callable){if($callable
instanceof\Closure){if($inner=self::unwrap($callable)){return'{closure '.self::toString($inner).'}';}return'{closure}';}elseif(is_string($callable)&&$callable[0]==="\0"){return'{lambda}';}else{is_callable($callable,TRUE,$textual);return$textual;}}static
function
toReflection($callable){if($callable
instanceof\Closure&&$inner=self::unwrap($callable)){$callable=$inner;}elseif($callable
instanceof
Nette\Callback){$callable=$callable->getNative();}if(is_string($callable)&&strpos($callable,'::')){return
new
Nette\Reflection\Method($callable);}elseif(is_array($callable)){return
new
Nette\Reflection\Method($callable[0],$callable[1]);}elseif(is_object($callable)&&!$callable
instanceof\Closure){return
new
Nette\Reflection\Method($callable,'__invoke');}else{return
new
Nette\Reflection\GlobalFunction($callable);}}static
function
isStatic($callable){return
is_array($callable)?is_string($callable[0]):is_string($callable);}static
function
unwrap(\Closure$closure){$rm=new\ReflectionFunction($closure);$vars=$rm->getStaticVariables();return
isset($vars['_callable_'])?$vars['_callable_']:NULL;}}use
RecursiveIteratorIterator;class
Finder
extends
Nette\Object
implements\IteratorAggregate{private$paths=array();private$groups;private$exclude=array();private$order=RecursiveIteratorIterator::SELF_FIRST;private$maxDepth=-1;private$cursor;static
function
find($mask){if(!is_array($mask)){$mask=func_get_args();}$finder=new
static;return$finder->select(array(),'isDir')->select($mask,'isFile');}static
function
findFiles($mask){if(!is_array($mask)){$mask=func_get_args();}$finder=new
static;return$finder->select($mask,'isFile');}static
function
findDirectories($mask){if(!is_array($mask)){$mask=func_get_args();}$finder=new
static;return$finder->select($mask,'isDir');}private
function
select($masks,$type){$this->cursor=&$this->groups[];$pattern=self::buildPattern($masks);if($type||$pattern){$this->filter(function($file)use($type,$pattern){return!$file->isDot()&&(!$type||$file->$type())&&(!$pattern||preg_match($pattern,'/'.strtr($file->getSubPathName(),'\\','/')));});}return$this;}function
in($path){if(!is_array($path)){$path=func_get_args();}$this->maxDepth=0;return$this->from($path);}function
from($path){if($this->paths){throw
new
Nette\InvalidStateException('Directory to search has already been specified.');}if(!is_array($path)){$path=func_get_args();}$this->paths=$path;$this->cursor=&$this->exclude;return$this;}function
childFirst(){$this->order=RecursiveIteratorIterator::CHILD_FIRST;return$this;}private
static
function
buildPattern($masks){$pattern=array();foreach($masks
as$mask){$mask=rtrim(strtr($mask,'\\','/'),'/');$prefix='';if($mask===''){continue;}elseif($mask==='*'){return
NULL;}elseif($mask[0]==='/'){$mask=ltrim($mask,'/');$prefix='(?<=^/)';}$pattern[]=$prefix.strtr(preg_quote($mask,'#'),array('\*\*'=>'.*','\*'=>'[^/]*','\?'=>'[^/]','\[\!'=>'[^','\['=>'[','\]'=>']','\-'=>'-'));}return$pattern?'#/('.implode('|',$pattern).')\z#i':NULL;}function
getIterator(){if(!$this->paths){throw
new
Nette\InvalidStateException('Call in() or from() to specify directory to search.');}elseif(count($this->paths)===1){return$this->buildIterator($this->paths[0]);}else{$iterator=new\AppendIterator();$iterator->append($workaround=new\ArrayIterator(array('workaround PHP bugs #49104, #63077')));foreach($this->paths
as$path){$iterator->append($this->buildIterator($path));}unset($workaround[0]);return$iterator;}}private
function
buildIterator($path){$iterator=new\RecursiveDirectoryIterator($path,\RecursiveDirectoryIterator::FOLLOW_SYMLINKS);if($this->exclude){$filters=$this->exclude;$iterator=new
Nette\Iterators\RecursiveFilter($iterator,function($foo,$foo,$file)use($filters){if(!$file->isDot()&&!$file->isFile()){foreach($filters
as$filter){if(!call_user_func($filter,$file)){return
FALSE;}}}return
TRUE;});}if($this->maxDepth!==0){$iterator=new
RecursiveIteratorIterator($iterator,$this->order);$iterator->setMaxDepth($this->maxDepth);}if($this->groups){$groups=$this->groups;$iterator=new
Nette\Iterators\Filter($iterator,function($foo,$foo,$file)use($groups){foreach($groups
as$filters){foreach($filters
as$filter){if(!call_user_func($filter,$file)){continue
2;}}return
TRUE;}return
FALSE;});}return$iterator;}function
exclude($masks){if(!is_array($masks)){$masks=func_get_args();}$pattern=self::buildPattern($masks);if($pattern){$this->filter(function($file)use($pattern){return!preg_match($pattern,'/'.strtr($file->getSubPathName(),'\\','/'));});}return$this;}function
filter($callback){$this->cursor[]=$callback;return$this;}function
limitDepth($depth){$this->maxDepth=$depth;return$this;}function
size($operator,$size=NULL){if(func_num_args()===1){if(!preg_match('#^(?:([=<>!]=?|<>)\s*)?((?:\d*\.)?\d+)\s*(K|M|G|)B?\z#i',$operator,$matches)){throw
new
Nette\InvalidArgumentException('Invalid size predicate format.');}list(,$operator,$size,$unit)=$matches;static$units=array(''=>1,'k'=>1e3,'m'=>1e6,'g'=>1e9);$size*=$units[strtolower($unit)];$operator=$operator?$operator:'=';}return$this->filter(function($file)use($operator,$size){return
Finder::compare($file->getSize(),$operator,$size);});}function
date($operator,$date=NULL){if(func_num_args()===1){if(!preg_match('#^(?:([=<>!]=?|<>)\s*)?(.+)\z#i',$operator,$matches)){throw
new
Nette\InvalidArgumentException('Invalid date predicate format.');}list(,$operator,$date)=$matches;$operator=$operator?$operator:'=';}$date=Nette\DateTime::from($date)->format('U');return$this->filter(function($file)use($operator,$date){return
Finder::compare($file->getMTime(),$operator,$date);});}static
function
compare($l,$operator,$r){switch($operator){case'>':return$l>$r;case'>=':return$l>=$r;case'<':return$l<$r;case'<=':return$l<=$r;case'=':case'==':return$l==$r;case'!':case'!=':case'<>':return$l!=$r;default:throw
new
Nette\InvalidArgumentException("Unknown operator $operator.");}}}class
Html
extends
Nette\Object
implements\ArrayAccess,\Countable,\IteratorAggregate{private$name;private$isEmpty;public$attrs=array();protected$children=array();public
static$xhtml=FALSE;public
static$emptyElements=array('img'=>1,'hr'=>1,'br'=>1,'input'=>1,'meta'=>1,'area'=>1,'embed'=>1,'keygen'=>1,'source'=>1,'base'=>1,'col'=>1,'link'=>1,'param'=>1,'basefont'=>1,'frame'=>1,'isindex'=>1,'wbr'=>1,'command'=>1,'track'=>1);static
function
el($name=NULL,$attrs=NULL){$el=new
static;$parts=explode(' ',$name,2);$el->setName($parts[0]);if(is_array($attrs)){$el->attrs=$attrs;}elseif($attrs!==NULL){$el->setText($attrs);}if(isset($parts[1])){foreach(Strings::matchAll($parts[1].' ','#([a-z0-9:-]+)(?:=(["\'])?(.*?)(?(2)\\2|\s))?#i')as$m){$el->attrs[$m[1]]=isset($m[3])?$m[3]:TRUE;}}return$el;}final
function
setName($name,$isEmpty=NULL){if($name!==NULL&&!is_string($name)){throw
new
Nette\InvalidArgumentException("Name must be string or NULL, ".gettype($name)." given.");}$this->name=$name;$this->isEmpty=$isEmpty===NULL?isset(static::$emptyElements[$name]):(bool)$isEmpty;return$this;}final
function
getName(){return$this->name;}final
function
isEmpty(){return$this->isEmpty;}function
addAttributes(array$attrs){$this->attrs=array_merge($this->attrs,$attrs);return$this;}final
function
__set($name,$value){$this->attrs[$name]=$value;}final
function&__get($name){return$this->attrs[$name];}final
function
__isset($name){return
isset($this->attrs[$name]);}final
function
__unset($name){unset($this->attrs[$name]);}final
function
__call($m,$args){$p=substr($m,0,3);if($p==='get'||$p==='set'||$p==='add'){$m=substr($m,3);$m[0]=$m[0]|"\x20";if($p==='get'){return
isset($this->attrs[$m])?$this->attrs[$m]:NULL;}elseif($p==='add'){$args[]=TRUE;}}if(count($args)===0){}elseif(count($args)===1){$this->attrs[$m]=$args[0];}elseif((string)$args[0]===''){$tmp=&$this->attrs[$m];}elseif(!isset($this->attrs[$m])||is_array($this->attrs[$m])){$this->attrs[$m][$args[0]]=$args[1];}else{$this->attrs[$m]=array($this->attrs[$m],$args[0]=>$args[1]);}return$this;}final
function
href($path,$query=NULL){if($query){$query=http_build_query($query,NULL,'&');if($query!==''){$path.='?'.$query;}}$this->attrs['href']=$path;return$this;}final
function
setHtml($html){if(is_array($html)){throw
new
Nette\InvalidArgumentException("Textual content must be a scalar, ".gettype($html)." given.");}$this->removeChildren();$this->children[]=(string)$html;return$this;}final
function
getHtml(){$s='';foreach($this->children
as$child){if(is_object($child)){$s.=$child->render();}else{$s.=$child;}}return$s;}final
function
setText($text){if(!is_array($text)&&!$text
instanceof
self){$text=htmlspecialchars((string)$text,ENT_NOQUOTES);}return$this->setHtml($text);}final
function
getText(){return
html_entity_decode(strip_tags($this->getHtml()),ENT_QUOTES,'UTF-8');}final
function
add($child){return$this->insert(NULL,$child);}final
function
create($name,$attrs=NULL){$this->insert(NULL,$child=static::el($name,$attrs));return$child;}function
insert($index,$child,$replace=FALSE){if($child
instanceof
Html||is_scalar($child)){if($index===NULL){$this->children[]=$child;}else{array_splice($this->children,(int)$index,$replace?1:0,array($child));}}else{throw
new
Nette\InvalidArgumentException("Child node must be scalar or Html object, ".(is_object($child)?get_class($child):gettype($child))." given.");}return$this;}final
function
offsetSet($index,$child){$this->insert($index,$child,TRUE);}final
function
offsetGet($index){return$this->children[$index];}final
function
offsetExists($index){return
isset($this->children[$index]);}function
offsetUnset($index){if(isset($this->children[$index])){array_splice($this->children,(int)$index,1);}}final
function
count(){return
count($this->children);}function
removeChildren(){$this->children=array();}final
function
getIterator($deep=FALSE){if($deep){$deep=$deep>0?\RecursiveIteratorIterator::SELF_FIRST:\RecursiveIteratorIterator::CHILD_FIRST;return
new\RecursiveIteratorIterator(new
Nette\Iterators\Recursor(new\ArrayIterator($this->children)),$deep);}else{return
new
Nette\Iterators\Recursor(new\ArrayIterator($this->children));}}final
function
getChildren(){return$this->children;}final
function
render($indent=NULL){$s=$this->startTag();if(!$this->isEmpty){if($indent!==NULL){$indent++;}foreach($this->children
as$child){if(is_object($child)){$s.=$child->render($indent);}else{$s.=$child;}}$s.=$this->endTag();}if($indent!==NULL){return"\n".str_repeat("\t",$indent-1).$s."\n".str_repeat("\t",max(0,$indent-2));}return$s;}final
function
__toString(){return$this->render();}final
function
startTag(){if($this->name){return'<'.$this->name.$this->attributes().(static::$xhtml&&$this->isEmpty?' />':'>');}else{return'';}}final
function
endTag(){return$this->name&&!$this->isEmpty?'</'.$this->name.'>':'';}final
function
attributes(){if(!is_array($this->attrs)){return'';}$s='';foreach($this->attrs
as$key=>$value){if($value===NULL||$value===FALSE){continue;}elseif($value===TRUE){if(static::$xhtml){$s.=' '.$key.'="'.$key.'"';}else{$s.=' '.$key;}continue;}elseif(is_array($value)){if($key==='data'){foreach($value
as$k=>$v){if($v!==NULL&&$v!==FALSE){$q=strpos($v,'"')===FALSE?'"':"'";$s.=' data-'.$k.'='.$q.str_replace(array('&',$q),array('&amp;',$q==='"'?'&quot;':'&#39;'),$v).$q;}}continue;}$tmp=NULL;foreach($value
as$k=>$v){if($v!=NULL){$tmp[]=$v===TRUE?$k:(is_string($k)?$k.':'.$v:$v);}}if($tmp===NULL){continue;}$value=implode($key==='style'||!strncmp($key,'on',2)?';':' ',$tmp);}else{$value=(string)$value;}$q=strpos($value,'"')===FALSE?'"':"'";$s.=' '.$key.'='.$q.str_replace(array('&',$q),array('&amp;',$q==='"'?'&quot;':'&#39;'),$value).$q;}$s=str_replace('@','&#64;',$s);return$s;}function
__clone(){foreach($this->children
as$key=>$value){if(is_object($value)){$this->children[$key]=clone$value;}}}}final
class
Json{const
FORCE_ARRAY=1;const
PRETTY=2;private
static$messages=array(JSON_ERROR_DEPTH=>'The maximum stack depth has been exceeded',JSON_ERROR_STATE_MISMATCH=>'Syntax error, malformed JSON',JSON_ERROR_CTRL_CHAR=>'Unexpected control character found',JSON_ERROR_SYNTAX=>'Syntax error, malformed JSON',5=>'Invalid UTF-8 sequence',6=>'Recursion detected',7=>'Inf and NaN cannot be JSON encoded',8=>'Type is not supported');final
function
__construct(){throw
new
Nette\StaticClassException;}static
function
encode($value,$options=0){$args=array($value);if(PHP_VERSION_ID>=50400){$args[]=JSON_UNESCAPED_UNICODE|($options&self::PRETTY?JSON_PRETTY_PRINT:0);}if(function_exists('ini_set')){$old=ini_set('display_errors',0);}set_error_handler(function($severity,$message){restore_error_handler();throw
new
JsonException($message);});$json=call_user_func_array('json_encode',$args);restore_error_handler();if(isset($old)){ini_set('display_errors',$old);}if($error=json_last_error()){throw
new
JsonException(isset(static::$messages[$error])?static::$messages[$error]:'Unknown error',$error);}$json=str_replace(array("\xe2\x80\xa8","\xe2\x80\xa9"),array('\u2028','\u2029'),$json);return$json;}static
function
decode($json,$options=0){$json=(string)$json;$args=array($json,(bool)($options&self::FORCE_ARRAY));$args[]=512;if(PHP_VERSION_ID>=50400){$args[]=JSON_BIGINT_AS_STRING;}$value=call_user_func_array('json_decode',$args);if($value===NULL&&$json!==''&&strcasecmp($json,'null')){$error=json_last_error();throw
new
JsonException(isset(static::$messages[$error])?static::$messages[$error]:'Unknown error',$error);}return$value;}}class
JsonException
extends\Exception{}final
class
MimeTypeDetector{final
function
__construct(){throw
new
Nette\StaticClassException;}static
function
fromFile($file){if(!is_file($file)){throw
new
Nette\FileNotFoundException("File '$file' not found.");}$info=@getimagesize($file);if(isset($info['mime'])){return$info['mime'];}elseif(extension_loaded('fileinfo')){$type=preg_replace('#[\s;].*\z#','',finfo_file(finfo_open(FILEINFO_MIME),$file));}elseif(function_exists('mime_content_type')){$type=mime_content_type($file);}return
isset($type)&&preg_match('#^\S+/\S+\z#',$type)?$type:'application/octet-stream';}static
function
fromString($data){if(extension_loaded('fileinfo')&&preg_match('#^(\S+/[^\s;]+)#',finfo_buffer(finfo_open(FILEINFO_MIME),$data),$m)){return$m[1];}elseif(strncmp($data,"\xff\xd8",2)===0){return'image/jpeg';}elseif(strncmp($data,"\x89PNG",4)===0){return'image/png';}elseif(strncmp($data,"GIF",3)===0){return'image/gif';}else{return'application/octet-stream';}}}class
Neon
extends
Nette\Object{const
BLOCK=1;private
static$patterns=array('
			\'[^\'\n]*\' |
			"(?: \\\\. | [^"\\\\\n] )*"
		','
			(?: [^#"\',:=[\]{}()\x00-\x20!`-] | [:-][^"\',\]})\s] )
			(?:
				[^,:=\]})(\x00-\x20]+ |
				:(?! [\s,\]})] | $ ) |
				[\ \t]+ [^#,:=\]})(\x00-\x20]
			)*
		','
			[,:=[\]{}()-]
		','?:\#.*','\n[\t\ ]*','?:[\t\ ]+');private
static$tokenizer;private
static$brackets=array('['=>']','{'=>'}','('=>')');private$input;private$tokens;private$n=0;private$indentTabs;static
function
encode($var,$options=NULL){if($var
instanceof\DateTime){return$var->format('Y-m-d H:i:s O');}elseif($var
instanceof
NeonEntity){return
self::encode($var->value).'('.substr(self::encode($var->attributes),1,-1).')';}if(is_object($var)){$obj=$var;$var=array();foreach($obj
as$k=>$v){$var[$k]=$v;}}if(is_array($var)){$isList=Arrays::isList($var);$s='';if($options&self::BLOCK){if(count($var)===0){return"[]";}foreach($var
as$k=>$v){$v=self::encode($v,self::BLOCK);$s.=($isList?'-':self::encode($k).':').(Strings::contains($v,"\n")?"\n\t".str_replace("\n","\n\t",$v):' '.$v)."\n";continue;}return$s;}else{foreach($var
as$k=>$v){$s.=($isList?'':self::encode($k).': ').self::encode($v).', ';}return($isList?'[':'{').substr($s,0,-2).($isList?']':'}');}}elseif(is_string($var)&&!is_numeric($var)&&!preg_match('~[\x00-\x1F]|^\d{4}|^(true|false|yes|no|on|off|null)\z~i',$var)&&preg_match('~^'.self::$patterns[1].'\z~x',$var)){return$var;}elseif(is_float($var)){$var=var_export($var,TRUE);return
Strings::contains($var,'.')?$var:$var.'.0';}else{return
json_encode($var);}}static
function
decode($input){if(!is_string($input)){throw
new
Nette\InvalidArgumentException("Argument must be a string, ".gettype($input)." given.");}if(!self::$tokenizer){self::$tokenizer=new
Tokenizer(self::$patterns,'mix');}if(substr($input,0,3)==="\xEF\xBB\xBF"){$input=substr($input,3);}$input=str_replace("\r",'',$input);$parser=new
static;$parser->input=$input;$parser->tokens=self::$tokenizer->tokenize($input);$res=$parser->parse(0);while(isset($parser->tokens[$parser->n])){if($parser->tokens[$parser->n][0][0]==="\n"){$parser->n++;}else{$parser->error();}}return$res;}private
function
parse($indent=NULL,$result=NULL){$inlineParser=$indent===NULL;$value=$key=$object=NULL;$hasValue=$hasKey=FALSE;$tokens=$this->tokens;$n=&$this->n;$count=count($tokens);for(;$n<$count;$n++){$t=$tokens[$n][0];if($t===','){if((!$hasKey&&!$hasValue)||!$inlineParser){$this->error();}$this->addValue($result,$hasKey,$key,$hasValue?$value:NULL);$hasKey=$hasValue=FALSE;}elseif($t===':'||$t==='='){if($hasKey||!$hasValue){$this->error();}if(is_array($value)||is_object($value)){$this->error('Unacceptable key');}$key=(string)$value;$hasKey=TRUE;$hasValue=FALSE;}elseif($t==='-'){if($hasKey||$hasValue||$inlineParser){$this->error();}$key=NULL;$hasKey=TRUE;}elseif(isset(self::$brackets[$t])){if($hasValue){if($t!=='('){$this->error();}$n++;$entity=new
NeonEntity;$entity->value=$value;$entity->attributes=$this->parse(NULL,array());$value=$entity;}else{$n++;$value=$this->parse(NULL,array());}$hasValue=TRUE;if(!isset($tokens[$n])||$tokens[$n][0]!==self::$brackets[$t]){$this->error();}}elseif($t===']'||$t==='}'||$t===')'){if(!$inlineParser){$this->error();}break;}elseif($t[0]==="\n"){if($inlineParser){if($hasKey||$hasValue){$this->addValue($result,$hasKey,$key,$hasValue?$value:NULL);$hasKey=$hasValue=FALSE;}}else{while(isset($tokens[$n+1])&&$tokens[$n+1][0][0]==="\n")$n++;if(!isset($tokens[$n+1])){break;}$newIndent=strlen($tokens[$n][0])-1;if($indent===NULL){$indent=$newIndent;}if($newIndent){if($this->indentTabs===NULL){$this->indentTabs=$tokens[$n][0][1]==="\t";}if(strpos($tokens[$n][0],$this->indentTabs?' ':"\t")){$n++;$this->error('Either tabs or spaces may be used as indenting chars, but not both.');}}if($newIndent>$indent){if($hasValue||!$hasKey){$n++;$this->error('Unexpected indentation.');}else{$this->addValue($result,$key!==NULL,$key,$this->parse($newIndent));}$newIndent=isset($tokens[$n])?strlen($tokens[$n][0])-1:0;$hasKey=FALSE;}else{if($hasValue&&!$hasKey){break;}elseif($hasKey){$this->addValue($result,$key!==NULL,$key,$hasValue?$value:NULL);$hasKey=$hasValue=FALSE;}}if($newIndent<$indent){return$result;}}}else{if($hasValue){$this->error();}static$consts=array('true'=>TRUE,'True'=>TRUE,'TRUE'=>TRUE,'yes'=>TRUE,'Yes'=>TRUE,'YES'=>TRUE,'on'=>TRUE,'On'=>TRUE,'ON'=>TRUE,'false'=>FALSE,'False'=>FALSE,'FALSE'=>FALSE,'no'=>FALSE,'No'=>FALSE,'NO'=>FALSE,'off'=>FALSE,'Off'=>FALSE,'OFF'=>FALSE);if($t[0]==='"'){$value=preg_replace_callback('#\\\\(?:u[0-9a-f]{4}|x[0-9a-f]{2}|.)#i',array($this,'cbString'),substr($t,1,-1));}elseif($t[0]==="'"){$value=substr($t,1,-1);}elseif(isset($consts[$t])){$value=$consts[$t];}elseif($t==='null'||$t==='Null'||$t==='NULL'){$value=NULL;}elseif(is_numeric($t)){$value=$t*1;}elseif(preg_match('#\d\d\d\d-\d\d?-\d\d?(?:(?:[Tt]| +)\d\d?:\d\d:\d\d(?:\.\d*)? *(?:Z|[-+]\d\d?(?::\d\d)?)?)?\z#A',$t)){$value=new
Nette\DateTime($t);}else{$value=$t;}$hasValue=TRUE;}}if($inlineParser){if($hasKey||$hasValue){$this->addValue($result,$hasKey,$key,$hasValue?$value:NULL);}}else{if($hasValue&&!$hasKey){if($result===NULL){$result=$value;}else{$this->error();}}elseif($hasKey){$this->addValue($result,$key!==NULL,$key,$hasValue?$value:NULL);}}return$result;}private
function
addValue(&$result,$hasKey,$key,$value){if($hasKey){if($result&&array_key_exists($key,$result)){$this->error("Duplicated key '$key'");}$result[$key]=$value;}else{$result[]=$value;}}private
function
cbString($m){static$mapping=array('t'=>"\t",'n'=>"\n",'r'=>"\r",'f'=>"\x0C",'b'=>"\x08",'"'=>'"','\\'=>'\\','/'=>'/','_'=>"\xc2\xa0");$sq=$m[0];if(isset($mapping[$sq[1]])){return$mapping[$sq[1]];}elseif($sq[1]==='u'&&strlen($sq)===6){return
Strings::chr(hexdec(substr($sq,2)));}elseif($sq[1]==='x'&&strlen($sq)===4){return
chr(hexdec(substr($sq,2)));}else{$this->error("Invalid escaping sequence $sq");}}private
function
error($message="Unexpected '%s'"){$last=isset($this->tokens[$this->n])?$this->tokens[$this->n]:NULL;list($line,$col)=Tokenizer::getCoordinates($this->input,$last?$last[Tokenizer::OFFSET]:strlen($this->input));$token=$last?str_replace("\n",'<new line>',Strings::truncate($last[0],40)):'end';throw
new
NeonException(str_replace('%s',$token,$message)." on line $line, column $col.");}}class
NeonEntity
extends\stdClass{public$value;public$attributes;}class
NeonException
extends\Exception{}class
Paginator
extends
Nette\Object{private$base=1;private$itemsPerPage=1;private$page;private$itemCount;function
setPage($page){$this->page=(int)$page;return$this;}function
getPage(){return$this->base+$this->getPageIndex();}function
getFirstPage(){return$this->base;}function
getLastPage(){return$this->itemCount===NULL?NULL:$this->base+max(0,$this->getPageCount()-1);}function
setBase($base){$this->base=(int)$base;return$this;}function
getBase(){return$this->base;}protected
function
getPageIndex(){$index=max(0,$this->page-$this->base);return$this->itemCount===NULL?$index:min($index,max(0,$this->getPageCount()-1));}function
isFirst(){return$this->getPageIndex()===0;}function
isLast(){return$this->itemCount===NULL?FALSE:$this->getPageIndex()>=$this->getPageCount()-1;}function
getPageCount(){return$this->itemCount===NULL?NULL:(int)ceil($this->itemCount/$this->itemsPerPage);}function
setItemsPerPage($itemsPerPage){$this->itemsPerPage=max(1,(int)$itemsPerPage);return$this;}function
getItemsPerPage(){return$this->itemsPerPage;}function
setItemCount($itemCount){$this->itemCount=($itemCount===FALSE||$itemCount===NULL)?NULL:max(0,(int)$itemCount);return$this;}function
getItemCount(){return$this->itemCount;}function
getOffset(){return$this->getPageIndex()*$this->itemsPerPage;}function
getCountdownOffset(){return$this->itemCount===NULL?NULL:max(0,$this->itemCount-($this->getPageIndex()+1)*$this->itemsPerPage);}function
getLength(){return$this->itemCount===NULL?$this->itemsPerPage:min($this->itemsPerPage,$this->itemCount-$this->getPageIndex()*$this->itemsPerPage);}}class
Strings{final
function
__construct(){throw
new
Nette\StaticClassException;}static
function
checkEncoding($s,$encoding='UTF-8'){return$s===self::fixEncoding($s,$encoding);}static
function
fixEncoding($s,$encoding='UTF-8'){if(PHP_VERSION_ID>=50400){ini_set('mbstring.substitute_character','none');return
mb_convert_encoding($s,$encoding,$encoding);}else{return@iconv('UTF-16','UTF-8//IGNORE',iconv($encoding,'UTF-16//IGNORE',$s));}}static
function
chr($code,$encoding='UTF-8'){return
iconv('UTF-32BE',$encoding.'//IGNORE',pack('N',$code));}static
function
startsWith($haystack,$needle){return
strncmp($haystack,$needle,strlen($needle))===0;}static
function
endsWith($haystack,$needle){return
strlen($needle)===0||substr($haystack,-strlen($needle))===$needle;}static
function
contains($haystack,$needle){return
strpos($haystack,$needle)!==FALSE;}static
function
substring($s,$start,$length=NULL){if($length===NULL){$length=self::length($s);}if(function_exists('mb_substr')){return
mb_substr($s,$start,$length,'UTF-8');}return
iconv_substr($s,$start,$length,'UTF-8');}static
function
normalize($s){$s=self::normalizeNewLines($s);$s=preg_replace('#[\x00-\x08\x0B-\x1F\x7F]+#','',$s);$s=preg_replace('#[\t ]+$#m','',$s);$s=trim($s,"\n");return$s;}static
function
normalizeNewLines($s){return
str_replace(array("\r\n","\r"),"\n",$s);}static
function
toAscii($s){$s=preg_replace('#[^\x09\x0A\x0D\x20-\x7E\xA0-\x{2FF}\x{370}-\x{10FFFF}]#u','',$s);$s=strtr($s,'`\'"^~',"\x01\x02\x03\x04\x05");if(ICONV_IMPL==='glibc'){$s=@iconv('UTF-8','WINDOWS-1250//TRANSLIT',$s);$s=strtr($s,"\xa5\xa3\xbc\x8c\xa7\x8a\xaa\x8d\x8f\x8e\xaf\xb9\xb3\xbe\x9c\x9a\xba\x9d\x9f\x9e"."\xbf\xc0\xc1\xc2\xc3\xc4\xc5\xc6\xc7\xc8\xc9\xca\xcb\xcc\xcd\xce\xcf\xd0\xd1\xd2\xd3"."\xd4\xd5\xd6\xd7\xd8\xd9\xda\xdb\xdc\xdd\xde\xdf\xe0\xe1\xe2\xe3\xe4\xe5\xe6\xe7\xe8"."\xe9\xea\xeb\xec\xed\xee\xef\xf0\xf1\xf2\xf3\xf4\xf5\xf6\xf8\xf9\xfa\xfb\xfc\xfd\xfe\x96","ALLSSSSTZZZallssstzzzRAAAALCCCEEEEIIDDNNOOOOxRUUUUYTsraaaalccceeeeiiddnnooooruuuuyt-");}else{$s=@iconv('UTF-8','ASCII//TRANSLIT',$s);}$s=str_replace(array('`',"'",'"','^','~'),'',$s);return
strtr($s,"\x01\x02\x03\x04\x05",'`\'"^~');}static
function
webalize($s,$charlist=NULL,$lower=TRUE){$s=self::toAscii($s);if($lower){$s=strtolower($s);}$s=preg_replace('#[^a-z0-9'.preg_quote($charlist,'#').']+#i','-',$s);$s=trim($s,'-');return$s;}static
function
truncate($s,$maxLen,$append="\xE2\x80\xA6"){if(self::length($s)>$maxLen){$maxLen=$maxLen-self::length($append);if($maxLen<1){return$append;}elseif($matches=self::match($s,'#^.{1,'.$maxLen.'}(?=[\s\x00-/:-@\[-`{-~])#us')){return$matches[0].$append;}else{return
self::substring($s,0,$maxLen).$append;}}return$s;}static
function
indent($s,$level=1,$chars="\t"){if($level>0){$s=self::replace($s,'#(?:^|[\r\n]+)(?=[^\r\n])#','$0'.str_repeat($chars,$level));}return$s;}static
function
lower($s){return
mb_strtolower($s,'UTF-8');}static
function
upper($s){return
mb_strtoupper($s,'UTF-8');}static
function
firstUpper($s){return
self::upper(self::substring($s,0,1)).self::substring($s,1);}static
function
capitalize($s){return
mb_convert_case($s,MB_CASE_TITLE,'UTF-8');}static
function
compare($left,$right,$len=NULL){if($len<0){$left=self::substring($left,$len,-$len);$right=self::substring($right,$len,-$len);}elseif($len!==NULL){$left=self::substring($left,0,$len);$right=self::substring($right,0,$len);}return
self::lower($left)===self::lower($right);}static
function
findPrefix($strings,$second=NULL){if(!is_array($strings)){$strings=func_get_args();}$first=array_shift($strings);for($i=0;$i<strlen($first);$i++){foreach($strings
as$s){if(!isset($s[$i])||$first[$i]!==$s[$i]){if($i&&$first[$i-1]>="\x80"&&$first[$i]>="\x80"&&$first[$i]<"\xC0"){$i--;}return
substr($first,0,$i);}}}return$first;}static
function
length($s){return
strlen(utf8_decode($s));}static
function
trim($s,$charlist=" \t\n\r\0\x0B\xC2\xA0"){$charlist=preg_quote($charlist,'#');return
self::replace($s,'#^['.$charlist.']+|['.$charlist.']+\z#u','');}static
function
padLeft($s,$length,$pad=' '){$length=max(0,$length-self::length($s));$padLen=self::length($pad);return
str_repeat($pad,$length/$padLen).self::substring($pad,0,$length
%$padLen).$s;}static
function
padRight($s,$length,$pad=' '){$length=max(0,$length-self::length($s));$padLen=self::length($pad);return$s.str_repeat($pad,$length/$padLen).self::substring($pad,0,$length
%$padLen);}static
function
reverse($s){return@iconv('UTF-32LE','UTF-8',strrev(@iconv('UTF-8','UTF-32BE',$s)));}static
function
random($length=10,$charlist='0-9a-z'){$charlist=str_shuffle(preg_replace_callback('#.-.#',function($m){return
implode('',range($m[0][0],$m[0][2]));},$charlist));$chLen=strlen($charlist);static$rand3;if(!$rand3){$rand3=md5(serialize($_SERVER),TRUE);}$s='';for($i=0;$i<$length;$i++){if($i
%
5===0){list($rand,$rand2)=explode(' ',microtime());$rand+=lcg_value();}$rand*=$chLen;$s.=$charlist[($rand+$rand2+ord($rand3[$i
%
strlen($rand3)]))%$chLen];$rand-=(int)$rand;}return$s;}static
function
split($subject,$pattern,$flags=0){set_error_handler(function($severity,$message)use($pattern){restore_error_handler();throw
new
RegexpException("$message in pattern: $pattern");});$res=preg_split($pattern,$subject,-1,$flags|PREG_SPLIT_DELIM_CAPTURE);restore_error_handler();if(preg_last_error()){throw
new
RegexpException(NULL,preg_last_error(),$pattern);}return$res;}static
function
match($subject,$pattern,$flags=0,$offset=0){if($offset>strlen($subject)){return
NULL;}set_error_handler(function($severity,$message)use($pattern){restore_error_handler();throw
new
RegexpException("$message in pattern: $pattern");});$res=preg_match($pattern,$subject,$m,$flags,$offset);restore_error_handler();if(preg_last_error()){throw
new
RegexpException(NULL,preg_last_error(),$pattern);}if($res){return$m;}}static
function
matchAll($subject,$pattern,$flags=0,$offset=0){if($offset>strlen($subject)){return
array();}set_error_handler(function($severity,$message)use($pattern){restore_error_handler();throw
new
RegexpException("$message in pattern: $pattern");});$res=preg_match_all($pattern,$subject,$m,($flags&PREG_PATTERN_ORDER)?$flags:($flags|PREG_SET_ORDER),$offset);restore_error_handler();if(preg_last_error()){throw
new
RegexpException(NULL,preg_last_error(),$pattern);}return$m;}static
function
replace($subject,$pattern,$replacement=NULL,$limit=-1){if(is_object($replacement)||is_array($replacement)){if($replacement
instanceof
Nette\Callback){$replacement=$replacement->getNative();}if(!is_callable($replacement,FALSE,$textual)){throw
new
Nette\InvalidStateException("Callback '$textual' is not callable.");}set_error_handler(function($severity,$message)use(&$tmp){restore_error_handler();throw
new
RegexpException("$message in pattern: $tmp");});foreach((array)$pattern
as$tmp){preg_match($tmp,'');}restore_error_handler();$res=preg_replace_callback($pattern,$replacement,$subject,$limit);if($res===NULL&&preg_last_error()){throw
new
RegexpException(NULL,preg_last_error(),$pattern);}return$res;}elseif($replacement===NULL&&is_array($pattern)){$replacement=array_values($pattern);$pattern=array_keys($pattern);}set_error_handler(function($severity,$message)use($pattern){restore_error_handler();throw
new
RegexpException("$message in pattern: ".implode(' or ',(array)$pattern));});$res=preg_replace($pattern,$replacement,$subject,$limit);restore_error_handler();if(preg_last_error()){throw
new
RegexpException(NULL,preg_last_error(),implode(' or ',(array)$pattern));}return$res;}}class
RegexpException
extends\Exception{static
public$messages=array(PREG_INTERNAL_ERROR=>'Internal error',PREG_BACKTRACK_LIMIT_ERROR=>'Backtrack limit was exhausted',PREG_RECURSION_LIMIT_ERROR=>'Recursion limit was exhausted',PREG_BAD_UTF8_ERROR=>'Malformed UTF-8 data',5=>'Offset didn\'t correspond to the begin of a valid UTF-8 code point');function
__construct($message,$code=NULL,$pattern=NULL){if(!$message){$message=(isset(self::$messages[$code])?self::$messages[$code]:'Unknown error').($pattern?" (pattern: $pattern)":'');}parent::__construct($message,$code);}}class
Tokenizer
extends
Nette\Object{const
VALUE=0,OFFSET=1,TYPE=2;private$re;private$types;function
__construct(array$patterns,$flags=''){$this->re='~('.implode(')|(',$patterns).')~A'.$flags;$keys=array_keys($patterns);$this->types=$keys===range(0,count($patterns)-1)?FALSE:$keys;}function
tokenize($input){if($this->types){$tokens=Strings::matchAll($input,$this->re);$len=0;$count=count($this->types);foreach($tokens
as&$match){$type=NULL;for($i=1;$i<=$count;$i++){if(!isset($match[$i])){break;}elseif($match[$i]!=NULL){$type=$this->types[$i-1];break;}}$match=array(self::VALUE=>$match[0],self::OFFSET=>$len,self::TYPE=>$type);$len+=strlen($match[self::VALUE]);}if($len!==strlen($input)){$errorOffset=$len;}}else{$tokens=Strings::split($input,$this->re,PREG_SPLIT_NO_EMPTY|PREG_SPLIT_OFFSET_CAPTURE);$last=end($tokens);if($tokens&&!Strings::match($last[0],$this->re)){$errorOffset=$last[1];}}if(isset($errorOffset)){list($line,$col)=$this->getCoordinates($input,$errorOffset);$token=str_replace("\n",'\n',substr($input,$errorOffset,10));throw
new
TokenizerException("Unexpected '$token' on line $line, column $col.");}return$tokens;}static
function
getCoordinates($text,$offset){$text=substr($text,0,$offset);return
array(substr_count($text,"\n")+1,$offset-strrpos("\n".$text,"\n")+1);}}class
TokenizerException
extends\Exception{}class
Validators
extends
Nette\Object{protected
static$validators=array('bool'=>'is_bool','boolean'=>'is_bool','int'=>'is_int','integer'=>'is_int','float'=>'is_float','number'=>NULL,'numeric'=>array(__CLASS__,'isNumeric'),'numericint'=>array(__CLASS__,'isNumericInt'),'string'=>'is_string','unicode'=>array(__CLASS__,'isUnicode'),'array'=>'is_array','list'=>array('Nette\Utils\Arrays','isList'),'object'=>'is_object','resource'=>'is_resource','scalar'=>'is_scalar','callable'=>array(__CLASS__,'isCallable'),'null'=>'is_null','email'=>array(__CLASS__,'isEmail'),'url'=>array(__CLASS__,'isUrl'),'none'=>array(__CLASS__,'isNone'),'type'=>array(__CLASS__,'isType'),'identifier'=>array('Nette\PhpGenerator\Helpers','isIdentifier'),'pattern'=>NULL,'alnum'=>'ctype_alnum','alpha'=>'ctype_alpha','digit'=>'ctype_digit','lower'=>'ctype_lower','upper'=>'ctype_upper','space'=>'ctype_space','xdigit'=>'ctype_xdigit');protected
static$counters=array('string'=>'strlen','unicode'=>array('Nette\Utils\Strings','length'),'array'=>'count','list'=>'count','alnum'=>'strlen','alpha'=>'strlen','digit'=>'strlen','lower'=>'strlen','space'=>'strlen','upper'=>'strlen','xdigit'=>'strlen');static
function
assert($value,$expected,$label='variable'){if(!static::is($value,$expected)){$expected=str_replace(array('|',':'),array(' or ',' in range '),$expected);if(is_array($value)){$type='array('.count($value).')';}elseif(is_object($value)){$type='object '.get_class($value);}elseif(is_string($value)&&strlen($value)<40){$type="string '$value'";}else{$type=gettype($value);}throw
new
AssertionException("The $label expects to be $expected, $type given.");}}static
function
assertField($arr,$field,$expected=NULL,$label="item '%' in array"){self::assert($arr,'array','first argument');if(!array_key_exists($field,$arr)){throw
new
AssertionException('Missing '.str_replace('%',$field,$label).'.');}elseif($expected){static::assert($arr[$field],$expected,str_replace('%',$field,$label));}}static
function
is($value,$expected){foreach(explode('|',$expected)as$item){list($type)=$item=explode(':',$item,2);if(isset(static::$validators[$type])){if(!call_user_func(static::$validators[$type],$value)){continue;}}elseif($type==='number'){if(!is_int($value)&&!is_float($value)){continue;}}elseif($type==='pattern'){if(preg_match('|^'.(isset($item[1])?$item[1]:'').'\z|',$value)){return
TRUE;}continue;}elseif(!$value
instanceof$type){continue;}if(isset($item[1])){if(isset(static::$counters[$type])){$value=call_user_func(static::$counters[$type],$value);}$range=explode('..',$item[1]);if(!isset($range[1])){$range[1]=$range[0];}if(($range[0]!==''&&$value<$range[0])||($range[1]!==''&&$value>$range[1])){continue;}}return
TRUE;}return
FALSE;}static
function
isNumericInt($value){return
is_int($value)||is_string($value)&&preg_match('#^-?[0-9]+\z#',$value);}static
function
isNumeric($value){return
is_float($value)||is_int($value)||is_string($value)&&preg_match('#^-?[0-9]*[.]?[0-9]+\z#',$value);}static
function
isCallable($value){return$value&&is_callable($value,TRUE);}static
function
isUnicode($value){return
is_string($value)&&preg_match('##u',$value);}static
function
isNone($value){return$value==NULL;}static
function
isList($value){return
Arrays::isList($value);}static
function
isInRange($value,$range){return(!isset($range[0])||$range[0]===''||$value>=$range[0])&&(!isset($range[1])||$range[1]===''||$value<=$range[1]);}static
function
isEmail($value){$atom="[-a-z0-9!#$%&'*+/=?^_`{|}~]";$localPart="(?:\"(?:[ !\\x23-\\x5B\\x5D-\\x7E]*|\\\\[ -~])+\"|$atom+(?:\\.$atom+)*)";$alpha="a-z\x80-\xFF";$domain="[0-9$alpha](?:[-0-9$alpha]{0,61}[0-9$alpha])?";$topDomain="[$alpha][-0-9$alpha]{0,17}[$alpha]";return(bool)preg_match("(^$localPart@(?:$domain\\.)+$topDomain\\z)i",$value);}static
function
isUrl($value){$alpha="a-z\x80-\xFF";$domain="[0-9$alpha](?:[-0-9$alpha]{0,61}[0-9$alpha])?";$topDomain="[$alpha][-0-9$alpha]{0,17}[$alpha]";return(bool)preg_match("(^https?://(?:(?:$domain\\.)*$topDomain|\\d{1,3}\.\\d{1,3}\.\\d{1,3}\.\\d{1,3}|\[[0-9a-f:]{3,39}\])(:\\d{1,5})?(/\\S*)?\\z)i",$value);}static
function
isType($type){return
class_exists($type)||interface_exists($type)||(PHP_VERSION_ID>=50400&&trait_exists($type));}}class
AssertionException
extends\Exception{}}namespace {Nette\Utils\SafeStream::register();class_alias('Nette\Configurator','Nette\Config\Configurator');function
callback($callback,$m=NULL){return
new
Nette\Callback($callback,$m);}use
Nette\Diagnostics\Debugger;function
dump($var){foreach(func_get_args()as$arg){Debugger::dump($arg);}return$var;}function
dlog($var=NULL){if(func_num_args()===0){Debugger::log(new
Exception,'dlog');}foreach(func_get_args()as$arg){Debugger::log($arg,'dlog');}return$var;}}