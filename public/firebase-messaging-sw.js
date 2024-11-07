/*

Give the service worker access to Firebase Messaging.
Note that you can only use Firebase Messaging here, other Firebase libraries are not available in the service worker.

*/

importScripts('https://www.gstatic.com/firebasejs/11.0.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/11.0.1/firebase-messaging.js');

/*

Initialize the Firebase app in the service worker by passing in the messagingSenderId.
* New configuration for app@pulseservice.com
*/

firebase.initializeApp({

    apiKey: "AIzaSyB-7-zwUwK0v1AdDv-IWc1ZqQZkN0MrrM8",
    authDomain: "gksm-3d7c2.firebaseapp.com",
    projectId: "gksm-3d7c2",
    storageBucket: "gksm-3d7c2.appspot.com",
    messagingSenderId: "131362520463",
    appId: "1:131362520463:web:3d99be3f6a3d0cfafa5ffa",
    measurementId: "G-GSYSMEE3YS"
    });

  

/*

Retrieve an instance of Firebase Messaging so that it can handle background messages.

*/

    const messaging = firebase.messaging();
    messaging.setBackgroundMessageHandler(function(payload) {
    console.log(
        "[firebase-messaging-sw.js] Received background message ",
        payload,
    );

    /* Customize notification here */
    const notificationTitle = "Background Message Title";
    const notificationOptions = {
        body: "Background Message body.",
        icon: "/itwonders-web-logo.png",
    };

    return self.registration.showNotification(
        notificationTitle,
        notificationOptions,
    );

    });