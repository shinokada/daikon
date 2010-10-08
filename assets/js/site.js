$(document).ready(function(){
	
    //configure the date format to match mysql date
    $('#date,#date_created,#date_completed').datepick({dateFormat: 'dd-mm-yy'});
    

    $("#accordion").accordion();
            $(".status").click(function () {
                  $(this).toggleClass("inactive");
            });

    $("#tablesorter_product").dataTable( {
            "aaSorting": [[ 1, "asc" ]],
            "iDisplayLength": 200,
            "oLanguage": {
                    "sLengthMenu": 'Display <select>'+
                            '<option value="20">20</option>'+
                            '<option value="40">40</option>'+
                            '<option value="60">60</option>'+
                            '<option value="80">80</option>'+
                            '<option value="100">100</option>'+
                            '<option value="-1">All</option>'+
                            '</select> records'
            }
    });

  
  $("#tablesorter").dataTable( {
      "iDisplayLength": 40,
      "oLanguage": {
      "sLengthMenu": 'Display <select>'+
	'<option value="20">20</option>'+
	'<option value="40">40</option>'+
	'<option value="60">60</option>'+
	'<option value="80">80</option>'+
	'<option value="100">100</option>'+
	'<option value="-1">All</option>'+
	'</select> records'
      }		
  } );

// for project log delete, projects/admin/showlog/

    $(".deleteme").live('click', function(event){

        event.preventDefault();
        var href = $(this).attr("href");
        //alert(href);
        var id =href.substring(href.lastIndexOf("/") + 1);
            jConfirm('Are you really sure? Do you want to delete?', 'Confirmation Dialog', function(r) {
                if (r==true){
                    $.ajax({
                        type: "POST",
                        url: href,
                        // data: id,
                        cache: false,
                        complete: function(){
                            //  jAlert ("log id of "+id+" has been deleted.");
                            $("#row_"+id).fadeOut("slow");
                      }
                     });

                    }

            });
    });

    

    // add class to a parent of field selected for projects/admin/newproject/
  $(".projectul input, .projectul textarea, .projectul select").focus(function() {
      $(this).closest("li").addClass("focused");
        }).blur(function() {
          $(this).closest("li").removeClass("focused");
        });



/*
 * for adminspec
 */

    var submitinput = $('#submitbtn input');
    var specdesc = $("#spec_desc");
    var datecreated = $("#date_created");
    var detailstext = $("#detailstext");// spec details textarea
  //  var tinymce =$("#tinymce"); not working, after ajax content remains

// Ajax
//on submit event
    $("#specformentry").submit(function(event){
        event.preventDefault();
        if(checkForm()){
          //  var href = $(this).attr("href");
            submitinput.attr({ disabled:true, value:"Sending..." });
            //$("#send").blur();
            //send the post to shoutbox.php
            $.ajax({
                type: "POST",
                url: "../../Ajaxinsertspec",
                data: $('#specformentry').serialize(),
                complete: function(data){
                     update_entry();
                     specdesc.val('');
                     datecreated.val('');
                     detailstext.val('');
                    // tinymce.val('');
                     if($('#noproject')){
                         $('#noproject').hide();
                     }

                    //reactivate the send button
                    submitinput.attr({ disabled:false, value:"Enter Spec" });
                }
             });
        }
        else alert("Please fill all fields!");
        //we prevent the refresh of the page after submitting the form
        return false;
    });

//check if all fields are filled
	function checkForm(){
		if(specdesc.attr("value") && datecreated.attr("value"))
			return true;
		else
			return false;
	}

    function update_entry(){
        var result =$('#result');
        var href = window.location.href;
        var id =href.substring(href.lastIndexOf("/") + 1);
        var tablespec = $("#tablespec");
        //just for the fade effect
        tablespec.fadeOut();
        
        // loading.fadeIn();
        //send the post 
        $.ajax({
                type: "POST",
                url: "../../Ajaxgetspec/"+id,
                // data: "action=update",
                success: function(data){
                    //console.log(data);
                    tablespec.html(data);
                    tablespec.fadeIn(2000);
                    

                        // loading.fadeOut();
                        //tablespec.html(data.responseText);
                        //tablespec.fadeIn(2000);
                        //completedList.fadeIn(2000);
                }
        });
    }

/*
    $(".toggle").click(function (event) {
    event.preventDefault();
    var id = "#"+$(this).attr('href');
    alert (id);
     $("id").slideToggle("slow");
});
*/




/* this works
$(".toggle").click(function (event) {
    event.preventDefault();
    var id = "#"+$(this).attr('href');
    $(id).slideToggle("slow");
  
});

        */
var baseurl = getBaseURL();

// the following does not work with live function

/*

$('.toggle').toggle(
   
   function(){
        var id = "#"+$(this).attr('alt'); // this will get desc77 and returns #desc77
        var idimg = id+"img";
        var arrowup = baseurl+"assets/icons/arrowup16.png";
        $(id).show('slow');
        $(idimg).attr('src', arrowup);
   }, function() {
       var id = "#"+$(this).attr('alt'); // this will get desc77 and returns #desc77
        var idimg = id+"img";
        var arrowdown = baseurl+"assets/icons/arrowdown16.png";
        $(id).hide('slow');
        $(idimg).attr('src',arrowdown);
   });
*/

$('.toggle').live('click', function() {
    var id = "#"+$(this).attr('alt'); // this will get desc77 and returns #desc77
    var idimg = id+"img";
    var arrowup = baseurl+"assets/icons/arrowup16.png";
    var arrowdown = baseurl+"assets/icons/arrowdown16.png";
    if($(id).is(':visible')){
        $(id).hide('slow');
        $(idimg).attr('src',arrowdown);
    } else {
      $(id).show('slow');
      $(idimg).attr('src', arrowup);
    };
});



function getBaseURL() {
    var url = location.href;  // entire url including querystring - also: window.location.href;
    var baseURL = url.substring(0, url.indexOf('/', 14));


    if (baseURL.indexOf('http://localhost') != -1) {
        // Base Url for localhost
        var url = location.href;  // window.location.href;
        var pathname = location.pathname;  // window.location.pathname;
        var index1 = url.indexOf(pathname);
        var index2 = url.indexOf("/", index1 + 1);
        var baseLocalUrl = url.substr(0, index2);

        return baseLocalUrl + "/";
    }
    else {
        // Root Url for domain name
        return baseURL + "/";
    }

}

// toggle textarea in showspec
$('#enterlabel').live('click', function() {
    $('#textarea').slideToggle("slow");
});


});