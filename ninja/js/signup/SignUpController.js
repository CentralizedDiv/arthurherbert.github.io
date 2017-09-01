angular.module('SignUp', [])  
.controller('SignUpController', SignUpController);

function SignUpController(widget, SignUpService) {
  widget.getMe = function() {
    var me = JSON.parse(window.sessionStorage.getItem('me'));
    this.name = me.name;
    this.email = me.email;
    this.picture = me.picture;
    this.cover   = me.cover;
    this.password = '';
    this.bio      = '';
    this.nickname = '';
  }

  widget.getMe();
  
  widget.cadastrar = function() {
    var me = {
      nome: this.name,
      email: this.email, 
      password: this.password,
      picture: this.picture,
      cover: this.cover,
      bio: this.bio,
      nickname: this.nickname
    };
    SignUpService.cadastrar(me).then(function successCallback(response) {

      if(response.data.cadastrado || response.data.cadastroRealizado)  window.location.href = 'index.html';
      if(response.data.erroCadastro) alert("Ocorreu um erro ao realizar o seu cadastro. Tente novamente mais tarde");
    }, function errorCallback(response) {
        return alert("Erro:" + response);
    }.bind(this));    
  }
  
  
    

}
    // -------------------------------------- CHAMADA BACKEND ---------------------------------------------- //

     
SignUpController.$inject = ['$scope', 'SignUpService'];