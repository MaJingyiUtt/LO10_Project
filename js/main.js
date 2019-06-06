var userId;
var userName;
var userGivenName;
var userFamilyName;
var userEmail;
function onSignIn(googleUser) {
    var profile = googleUser.getBasicProfile();
    userId = profile.getId();
    userName = profile.getName();
    userGivenName = profile.getGivenName();
    userFamilyName = profile.getFamilyName();
    userEmail = profile.getEmail();

    // The ID token you need to pass to your backend:
    var id_token = googleUser.getAuthResponse().id_token;
    console.log("ID Token: " + id_token);
    $.ajax({
      url: "http://18.222.63.99:3000/userId/"+userId,
      header: "Access-Control-Allow-Origin: *",
      type: "GET",
      dataType: "json",
      success: function (data) {
          console.log(data);
          if(data.isNew){
            window.location.href = "firstLogin.html";
          }else{
            window.location.href = "user.html";
          }
          
      }
  });
}