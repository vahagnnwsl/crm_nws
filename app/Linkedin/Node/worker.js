const fs = require('fs'),
    path = require('path'),
    {fork} = require("child_process");


let strUsers = fs.readFileSync('./storage/linkedin/linkedin_users.json'),
    users = JSON.parse(strUsers);


(async () => {



    users.map(function (user) {
        const childProcess = fork(path.join(path.dirname(__filename), 'eventsource.js'));

        childProcess.send(user);

        childProcess.on("message", function (message) {
            console.log(message)
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



