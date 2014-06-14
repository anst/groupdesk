

$( document ).ready(function() {

ROOM_ID = location.href.replace('#','').split('/')[location.href.replace('#','').split('/').length-1];
var announcements = new Firebase('https://schollab.firebaseio.com/announcement_'+ROOM_ID);
var todo = new Firebase('https://schollab.firebaseio.com/todo_'+ROOM_ID);
var chat = new Firebase('https://schollab.firebaseio.com/chat_'+ROOM_ID);

$("#postAnnouncement").click(function() {
	var msg = $('#announcementText').val();
	var name = $('#fullname').text();
	announcements.push({name:name, text:msg});
	$('#announcementText').val('');
});

announcements.on('child_added', function (snapshot) {
	var message = snapshot.val();

	$('#announcements').append('<div class="panel panel-default" style="background: rgba(0,0,0,0.03)">\
                    <div class="panel-body">\
                      <legend>\
                        <h5><b>'+message.name+'</b> said:</h5>\
                      </legend>'+message.text+'\
                    </div>\
                  </div>');
	$('#announcements')[0].scrollTop = $('#announcements')[0].scrollHeight;
});


$("#sendMessage").click(function() {
	var msg = $('#messageText').val();
	var name = $('#fullname').text();
	chat.push({name:name, text:msg});
	$('#messageText').val('');
});

chat.on('child_added', function (snapshot) {
	var message = snapshot.val();
	$('#messages').append('<div class="panel panel-default" style="background: rgba(0,0,0,0.03)"><div class="panel-body"><b>'+message.name+': </b>'+message.text+'</div>');
	$('#messages')[0].scrollTop = $('#messages')[0].scrollHeight;
});


$("#addTodo").click(function() {
	var msg = $('#todoText').val();
	var iid = makeid();
	todo.child(iid).update({id:iid,text:msg, completed:false});
	$('#todoText').val('');
});



$(document).on('click', "a.okbtn", function() {
    var liId = $(this).attr("id").substring(2);
    todo.child(liId).update({completed:true});
});
$(document).on('click', "a.rmbtn", function() {
    var liId = $(this).attr("id").substring(2);
    todo.child(liId).remove();
});
todo.on('child_added', function (snapshot) {
	var message = snapshot.val();	            
	$('#todoList').append( '<div class="panel panel-default" style="background: rgba(0,0,0,0.03)">\
                    <div class="panel-body">\
                      <div class="row">\
                        <div class="col-md-8" style="'+(message.completed==true?"color:rgba(0,0,0,0.3)":"")+'">'+
                          message.text+'\
                        </div>\
                        <div class="col-md-4" style="text-align:right;">\
                          <a href="#" id="ok'+ message.id+'" class="btn btn-success btn-xs okbtn '+(message.completed==true?"disabled":"")+'"><i class="glyphicon glyphicon-ok"></i></a>&nbsp;&nbsp;<a href="#" id="rm'+ message.id+'" class="btn btn-danger btn-xs rmbtn" ><i class="glyphicon glyphicon-remove"></i></a>\
                        </div>\
                      </div>\
                    </div>\
                  </div>');
	console.log("my object: %o", message);
	$('#todoList')[0].scrollTop = $('#todoList')[0].scrollHeight;
});
todo.on('child_changed',function(snapshot){
	var message = snapshot.val();
	$('#ok'+message.id).addClass('disabled').parent().parent().first().css('color','rgba(0,0,0,0.3)');
});
todo.on('child_removed', function(snapshot) {
	var message = snapshot.val();
	var id = message.id;
	$('#rm'+id).parent().parent().parent().parent().css('display','none');

});

function makeid()
{
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for( var i=0; i < 5; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}
});