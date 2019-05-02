var userController = {
    data: {
        config: null,
        cognitoAuth: null,
        cognitoSession: null
    },
    uiElements: {
        loginButton: null,
        logoutButton: null,
        profileButton: null,
        profileNameLabel: null,
        myCarousel : null,//mjy
        profileImage: null,
        uploadButton: null
    },
    init: function (config) {
        this.uiElements.loginButton = $('#cognito-login');
        this.uiElements.logoutButton = $('#cognito-logout');
        this.uiElements.profileButton = $('#user-profile');
        this.uiElements.profileNameLabel = $('#profilename');
        this.uiElements.profileImage = $('#profilepicture');
        this.uiElements.uploadButton = $('#upload-video-button');
        this.uiElements.myCarousel = $('#myCarousel');
        this.data.config = config;

        // check to see if the user has previously logged in
        this.data.cognitoAuth = this.initCognitoSDK()
        this.data.cognitoAuth.parseCognitoWebResponse(window.location.href);
        this.configureAuthenticatedRequests()

        this.wireEvents();
    },
    initCognitoSDK() {
		var authData = {
			ClientId : this.data.config.cognito.clientId,
			AppWebDomain : this.data.config.cognito.domain,
			TokenScopesArray : ['phone', 'email', 'openid', 'aws.cognito.signin.user.admin', 'profile'],
			RedirectUriSignIn : this.data.config.cognito.redirectUri,
			RedirectUriSignOut : this.data.config.cognito.redirectUri,
            UserPoolId : this.data.config.cognito.userPoolId, 
            AdvancedSecurityDataCollectionFlag : false
		};

        var auth = new AmazonCognitoIdentity.CognitoAuth(authData);
        var that = this

        auth.userhandler = {
			onSuccess: function(result) {
                that.data.cognitoSession = result
                that.uiElements.profileNameLabel.text(auth.getUsername());
                that.uiElements.uploadButton.css('display', 'inline-block');
                that.uiElements.loginButton.toggle(false);
                that.uiElements.logoutButton.toggle(true);
                that.uiElements.profileButton.toggle(true);
                that.uiElements.myCarousel.toggle(false);
            },
			onFailure: function(result) {
                that.uiElements.profileNameLabel.text('');
                that.uiElements.uploadButton.hide();
                that.uiElements.loginButton.toggle(true);
                that.uiElements.logoutButton.toggle(false);
                that.uiElements.profileButton.toggle(false);
                that.uiElements.myCarousel.toggle(false);
            }
        };
        // We do not use Authorization code grant flow
		// auth.useCodeGrantFlow();
		return auth;
	},
    configureAuthenticatedRequests: function () {
        that = this
        $.ajaxSetup({
            'beforeSend': function (xhr) {
                xhr.setRequestHeader('Authorization', 'Bearer ' + that.data.cognitoSession.getIdToken().getJwtToken())
            }
        });
    },
    wireEvents: function () {
        var that = this;

        this.uiElements.loginButton.click(function (e) {
            that.data.cognitoAuth.getSession()
        });

        this.uiElements.logoutButton.click(function (e) {
            that.data.cognitoAuth.signOut();

            that.uiElements.uploadButton.hide();
            that.uiElements.logoutButton.hide();
            that.uiElements.profileButton.hide();
            that.uiElements.loginButton.show();
        });

        this.uiElements.profileButton.click(function (e) {
            var url = that.data.config.apiBaseUrl + '/user-profile';
            var button = $(this);
            button.button('loading');

            $.get(url).done(function (data, status) {
                // save user profile data in the modal
                $('#user-profile-raw-json').text(JSON.stringify(data, null, 2));
                $('#user-profile-modal').modal();
                button.button('reset');
            }).fail(function (error) {
                alert('Can\'t retreive user information');
                button.button('reset');
                console.error(error);
            });
        });
    }
};
