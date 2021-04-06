const fs = require('fs'),
    path = require('path'),
    {fork} = require("child_process"),
    axios = require('axios');


let strUsers = fs.readFileSync('./storage/linkedin/linkedin_users.json'),
    users = JSON.parse(strUsers);


(async () => {


    users.map(function (user) {

        const childProcess = fork(path.join(path.dirname(__filename), 'eventsource.js'));

        childProcess.send(user);

        childProcess.on("message", function (message) {

            axios.post(message.url, message.payloadReq).then((response) => {
                console.log(response.data)
            }).catch((e) => {
                console.log(e)
            })

        })

        childProcess.on('error', function (e) {
            console.log(e)
        });

        childProcess.once('close', function (e) {
            console.log('closing...' + e);
        });

        childProcess.once('exit', function (e) {
            console.log('exiting...' + e);
        });

    })
})()



