$(document).ready(function() {
    var chatInterval = 250; //refresh interval in ms
    var $userName = $("#userName");
    var $chatOutput = $("#chatOutput");
    var $chatInput = $("#chatInput");
    var $chatSend = $("#chatSend");

    var scrolled = false;

    $chatSend.click(function() {
        sendMessage();
    });

    setInterval(function() {
        retrieveMessages();
    }, chatInterval);

    function sendMessage() {
        var userNameString = $userName.val();
        var chatInputString = $chatInput.val();

        $.get("./chatWrite.php", {
            username: userNameString,
            text: chatInputString
        });

        $userName.val("");
        $chatInput.val("");
        retrieveMessages();
    }

    function retrieveMessages() {
        $.get("./chatRead.php", function(data) {
            $chatOutput.html(data); //Paste content into chat output
        });

        updateScroll();
    }

    function updateScroll(){
      if(!scrolled){
        var element = document.getElementById("chatOutput");
        element.scrollTop = element.scrollHeight;
      }
    }

    $("#chatOutput").on('scroll', function(){
      scrolled=true;
    });
  });
