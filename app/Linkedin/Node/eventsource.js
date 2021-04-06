const EventSource = require('eventsource'),
    fs = require('fs');

process.on("message", message => {

    let strCookie = fs.readFileSync('./storage/linkedin/cookies/' + message.login + '.json');

    let cookies = JSON.parse(strCookie);

    let eventSourceInitDict = {
        headers: {
            'accept': 'text/event-stream',
            'accept-encoding': 'gzip, deflate, br',
            'accept-language': 'en-US,en;q=0.9',
            'origin': 'https://www.linkedin.com',
            'referer': 'https://www.linkedin.com/',
            'cookie': cookies.str,
            'csrf-token': cookies.crfToken,
            'user-agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36',
            'x-li-accept': 'application/vnd.linkedin.normalized+json+2.1',
            'x-li-page-instance': 'urn:li:page:feed_index_index;4x/cLqhlTY6xYQJ1S0umfQ==',
            'x-li-track': '{"clientVersion":"1.8.2073","mpVersion":"1.8.2073","osName":"web","timezoneOffset":4,"timezone":"Asia/Yerevan","deviceFormFactor":"DESKTOP","mpName":"voyager-web","displayDensity":1,"displayWidth":1920,"displayHeight":1080}',
            'x-restli-protocol-version': '2.0.0'
        }
    };

    function getConversationDetails(str) {
        let arr = str.split(':')
        let f = arr[3].substring(1, arr[3].length - 1);
        return f.split(',');
    }

    function getMessageEntityUrn(str) {
        return str.split(':')[3];
    }

    var es = new EventSource('https://realtime.www.linkedin.com/realtime/connect', eventSourceInitDict);

    let key = 'com.linkedin.realtimefrontend.DecoratedEvent';

    es.onmessage = result => {

        const data = JSON.parse(result.data);

        if (data.hasOwnProperty(key)) {

            var eventContent = data[key];

            if (eventContent.hasOwnProperty('topic')) {

                if (eventContent.hasOwnProperty('publisherTrackingId')) {

                    let payload = eventContent.payload;

                    if (payload.included.length) {

                        let payloadReq = {
                            text: payload.included[1].eventContent.attributedBody.text,
                            conversation_entityUrn: getConversationDetails(payload.included[1]['*from'])[0],
                            user_entityUrn: getConversationDetails(payload.included[1]['*from'])[1],
                            entityUrn: getMessageEntityUrn(payload.included[1].backendUrn),
                            date: payload.included[1].createdAt,
                            user_login: message.login
                        }

                        if (payload.included[1].eventContent.hasOwnProperty('customContent') && payload.included[1].eventContent.customContent.hasOwnProperty('media')) {
                            payloadReq.media = payload.included[1].eventContent.customContent.media;
                        }

                        if (payload.included[1].eventContent.hasOwnProperty('attachments')) {
                            payloadReq.attachments = payload.included[1].eventContent.attachments;
                        }

                        if (payloadReq.user_entityUrn !== message.entityUrn) {

                            process.send({
                                url: `http://nws-crm.loc/api/conversations/${payloadReq.conversation_entityUrn}/messages`,
                                payloadReq: payloadReq
                            });
                        }
                    }
                }
            }
        }
    };

    es.onerror = err => {
        console.log('EventSource error: ', err);
    };

})
