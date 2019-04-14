$(document).ready(function () {
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
    });

    $('.components li').on('click', function() {
    	$('.components li').removeClass('active');
    	$(this).addClass('active');
    });

    $(this).delay(100).queue(function() {

        if($('.chatbox').length) {
            $('.chatbox').scrollTop($('.chatbox')[0].scrollHeight);
        }

     $(this).dequeue();

    });

    fetch_user();
    update_chat_history_data();
    update_scroll_height();

    setInterval(function() {
        update_last_activity();
        fetch_user();
        update_chat_history_data();
        update_scroll_height();
    }, 5000);

    function fetch_user() {
    	$.ajax({
    		url: "fetch_user.php",
    		method: "POST",
    		success: function(data) {
    			$('.online-member-list').html(data);
    		}
    	});
    }

    function update_last_activity() {
        $.ajax({
            url: "update_last_activity.php",
            success:function() {
            }
        });
    }

    function update_scroll_height() {

        if($('.chatbox').length) {
            $('.chatbox').scrollTop($('.chatbox')[0].scrollHeight);
        }
 
    }

    function update_channel_list() {
        $.ajax({
            url: "fetch_channel_list.php",
            success: function() {

            }
        });
    }

    function fetch_user_chat_history(to_channel_id) {
        $.ajax({
            url: "fetch_user_chat_history.php",
            method: "POST",
            data: {to_channel_id:to_channel_id},
            success: function(data) {
                $('#chat_history_'+to_channel_id).html(data);
            }
        });
    }

    function update_session_channel_list(new_channel_name) {
        $.ajax({
            url: "update_session_channel_list.php",
            method: "POST",
            data: {new_channel_name:new_channel_name},
            success: function(data) {
                $('#sidebar_channel_list').append(data);
                console.log("SUCCESS");
                
            }
        });
    }

    function update_chat_history_data() {
        $('.chat_history').each(function() {
            var to_channel_id = $(this).attr('data-tochannelid');
            fetch_user_chat_history(to_channel_id);
            update_scroll_height();
            //console.log("updating history to channel: " +to_channel_id);
        });
    }

    $(document).on('click', '#create_channel_btn', function() {

       
        var get_chname = $('#create_chname').val();
        update_session_channel_list(get_chname);


    });

    $(document).on('click', '.send_chat', function() {
        var to_channel_id = $(this).attr('data-tochannelid');
        var ch_message = $('#chat_message_' + to_channel_id).val();

        $.ajax({
            url: "insert_chat.php",
            method: "POST",
            data: {to_channel_id:to_channel_id, ch_message:ch_message},
            success: function(data) {
                $('#chat_message_'+to_channel_id).val('');
                $('#chat_history_'+to_channel_id).html(data);
                update_scroll_height();
            }
        })
    });

    $(document).on('click', '#join_channel', function() {

        var user_id = $(this).attr("data-userid");

        $.ajax({
            url: "join_channel.php",
            method: "POST",
            async: true,
            data: {},
            success: function() {

            }
        })

    });

    $(document).on('click', '#channel_item', function() {
        
        var current_chan = $(this).attr("data-channelid");
        var set_chan = $('.send_chat').attr('data-tochannelid');
        $('#chat_history_list').empty();

        $.ajax({
            url: "set_current_channel.php",
            method: "POST",
            async: true,
            data: {channel_id:current_chan},
            success: function(data) {

                $('.chatbox').attr('data-tochannelid', current_chan);
                $('.chat_history').attr("id", "chat_history_" + current_chan).html();
                $('#chat_message_' + set_chan).attr("id", "chat_message_"+current_chan);
                $('.send_chat').attr('data-tochannelid', current_chan);
                $('textarea').attr("name", "chat_message_"+current_chan);
                update_chat_history_data();
                update_scroll_height();
                
            }
        })

    });

    (() => {
      'use strict';
      // Page is loaded
      const objects = document.getElementsByClassName('asyncImage');
      Array.from(objects).map((item) => {
        // Start loading image
        const img = new Image();
        img.src = item.dataset.src;
        // Once image is loaded replace the src of the HTML element
        img.onload = () => {
          item.classList.remove('asyncImage');
          return item.nodeName === 'IMG' ? 
            item.src = item.dataset.src :        
            item.style.backgroundImage = `url(${item.dataset.src})`;
        };
      });
    })();


});