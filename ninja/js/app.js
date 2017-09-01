var Login = angular.module('Login', []);
var SignUp = angular.module('SignUp', []);
var Ninja = angular.module('Ninja', ['ngTouch']);

window.fbAsyncInit = function() {
  FB.init({
    appId      : '326198331145514',
    cookie     : true,
    xfbml      : true,
    version    : 'v2.8'
  });
  FB.AppEvents.logPageView();   
};

(function(d, s, id){
   var js, fjs = d.getElementsByTagName(s)[0];
   if (d.getElementById(id)) {return;}
   js = d.createElement(s); js.id = id;
   js.src = "//connect.facebook.net/en_US/sdk.js";
   fjs.parentNode.insertBefore(js, fjs);
 }(document, 'script', 'facebook-jssdk'));