import firebase from "firebase";

if (!firebase.apps.length) {
  firebase.initializeApp({
    apiKey: "AIzaSyAvAkkHgvafRcQtLrypvnJ-DtJie4PeXnw",
  authDomain: "fir-2-10058.firebaseapp.com",
  projectId: "fir-2-10058",
  storageBucket: "fir-2-10058.appspot.com",
  messagingSenderId: "959163559303",
  appId: "1:959163559303:web:aaa7391ba77ebd7363f722",
  measurementId: "G-03JMV2GWRB"
  });
}

export default firebase;