importScripts('https://www.gstatic.com/firebasejs/5.5.8/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/5.5.8/firebase-messaging.js');

const config = {
    apiKey: "AIzaSyCXklG232X3RFoUI9fbLbchcOUjOoO4QGo",
    authDomain: "test-b15ce.firebaseapp.com",
    projectId: "test-b15ce",
    storageBucket: "test-b15ce.appspot.com",
    messagingSenderId: "808179491697",
    appId: "1:808179491697:web:163cd8c2719cbe50e88cd0"
};
firebase.initializeApp(config);
const messaging = firebase.messaging();

messaging.setBackgroundMessageHandler(function(payload) {
    let title = payload.data.title;
    var options = {
        body: payload.data.body,
        icon: payload.data.icon,
        image: payload.data.image,
        data:{
            time: new Date(Date.now()).toString(),
            click_action: payload.data.click_action
        }
    };

    return self.registration.showNotification(title, options); 
});