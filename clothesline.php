<!DOCTYPE html>
<html class="ui-mobile">
    <head>
        <style>
   
            </style>

            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
			<link rel="shortcut icon" type="image/png" href="img/ic_launcher-web.png"/>
			
            <title>MicrogearAgent</title>
            <!--link rel="stylesheet" href="css/jquery.mobile-1.3.2.min.css"-->
            <link rel="stylesheet" href="css/jqm-demos.css">
            <link rel="stylesheet" href="css/fonts.css">
            <script src="js/jquery.js"></script>
            <!--script src="_assets/js/index.js"></script-->
            <!--script src="js/jquery.mobile-1.3.2.min.js"></script-->
            <script src="js/microgear.js"></script>
            <script>
                var member = [];
                var autoscroll = true;
                var name = "CtrlC";
				var recv = "CtrlV";
                var microgear;
                setInformation();

                function setInformation() {
                    const APPKEY = "h1sAAeIkJN06CbM";
                            const APPSECRET = "CtEPQT5IamWJizjSkSoQEH5fZ";
                            const APPID = "proj4u";
                            microgear = Microgear.create({
                                gearkey: APPKEY,
                                gearsecret: APPSECRET
                            });

                    microgear.on('message', function (topic, msg) {
                        console.log(msg);
						$('#txtConsole').append(msg+"\n");
						
                      /*  var message = msg.trim().split('#');
                        var src = message[1];
                        var cmd = message[2].split("=");
                        var param=cmd[0];
                        var value=cmd[1];
                        
                        if(param=="pins"){
                            var pins=value.split(",");
                            for (i = 0; i < pins.length; i++) {
                                if (parseInt(pins[i]) > 0) {
                                    $('#ch' + i).removeClass('btn').addClass('btn-s');
                                } else {
                                    $('#ch' + i).removeClass('btn-s').addClass('btn');
                                }
                            }
                        }*/
                    });

                    microgear.on('connected', function () {
                        microgear.subscribe("/chat");
                        microgear.setAlias(name);
                        microgear.publish("/chat", "I'm new#" + name);
                        microgear.publish("/chat", "Hi#" + name);
                    });
                    microgear.on('present', function (event) {
                        console.log(event);
                    });
                    microgear.on('absent', function (event) {
                        console.log(event);
                    });
                    microgear.resettoken(function () {
                        microgear.connect(APPID);
                    });
                }
            </script>
        </head>
        <body class="ui-mobile-viewport ui-overlay-c" id="ui-page-top">
		<table><tr><td>
		<table>
		<tr><td>Auto</td><td><input type="text" id="mode"></td></tr>
		<tr><td>Status</td><td><input type="text" id="sta"></td></tr>
		<tr><td>Raindrop</td><td><input type="text" id="rain"></td></tr>
		<tr><td>Luxmeter</td><td><input type="text" id="lux"></td></tr>
	<tr><td></td><td><input type="button" value="send" id="raw"/></td></tr>
		</table>
		</td>
		<td valign="top" align="right">
		<table>
		<tr><td><input type="button" id="rainNotic" value="RainyNotify"/></td></tr>
		<tr><td><input type="button" id="luxNotic" value="LuxmyNotify"/></td></tr>
		</table>
		</td>
		<td valign="top">
		<table>
		<tr><td><input type="text" id="message"></td><td><input type="button" value="Send Command"></td></tr>
		</table>
		</td>
		</tr></table>
<textarea id="txtConsole" style="width:600px;height:300px;"></textarea>
                <script>
                    $(document).ready(function () {
                        //setTimeout(setButtonState, 100);
                    });
                    
                    $('#raw').click(function(){
                        chat("msg",$("#mode").val()+","+$("#sta").val()+","+$("#rain").val()+","+$("#lux").val());
                    });
                    
					 $('#rainNotic').click(function(){
						 //rainy
                        chat("notify","rainy");
                    });
					 $('#luxNotic').click(function(){
						 //cloudy
                        chat("notify","cloudy");
                    });
                    
                    function disconnect() {
                        microgear.publish("/chat", "bye#" + name);
                    }
                    function chat(header,msg) {
                        microgear.publish("/chat", "$"+header+"" + name + "#"+recv+"#" + msg);
                    }

                </script>
                <!--div class="ui-panel-dismiss" data-panelid="null"></div><div class="ui-panel-dismiss" data-panelid="null"></div></div><!-- /page -->
            </body>
        </html>