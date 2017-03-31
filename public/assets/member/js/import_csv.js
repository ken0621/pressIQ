var import_csv = new import_csv();
var main_file  = '';
var ctr = 0;

function import_csv()
{
    init();
    function init()
    {
        document_ready();
    }
    
    function document_ready()
    {
        event_bind_files();
        event_submit_button();
    }

    function event_bind_files()
    {
        if(isAPIAvailable()) {
            $('#files').bind('change', handleFileSelect);
            console.log("true");
        }
        
    }

    function isAPIAvailable() {
      // Check for the various File API support.
      if (window.File && window.FileReader && window.FileList && window.Blob) {
        // Great success! All the File APIs are supported.
        return true;
      } else {
        // source: File API availability - http://caniuse.com/#feat=fileapi
        // source: <output> availability - http://html5doctor.com/the-output-element/
        document.writeln('The HTML5 APIs used in this form are only available in the following browsers:<br />');
        // 6.0 File API & 13.0 <output>
        document.writeln(' - Google Chrome: 13.0 or later<br />');
        // 3.6 File API & 6.0 <output>
        document.writeln(' - Mozilla Firefox: 6.0 or later<br />');
        // 10.0 File API & 10.0 <output>
        document.writeln(' - Internet Explorer: Not supported (partial support expected in 10.0)<br />');
        // ? File API & 5.1 <output>
        document.writeln(' - Safari: Not supported<br />');
        // ? File API & 9.2 <output>
        document.writeln(' - Opera: Not supported');
        return false;
      }
    }

    function handleFileSelect(evt) {
      var files = evt.target.files; // FileList object
      var file  = files[0];
      main_file = file;

      // read the file metadata
      var output = ''
          output += '<span style="font-weight:bold;">' + escape(file.name) + '</span><br />\n';
          output += ' - FileType: ' + (file.type || 'n/a') + '<br />\n';
          output += ' - FileSize: ' + file.size + ' bytes<br />\n';
          output += ' - LastModified: ' + (file.lastModifiedDate ? file.lastModifiedDate.toLocaleDateString() : 'n/a') + '<br />\n';

      $(".btn-submit").removeAttr("disabled");

      // read the file contents
      // Load_array(file);

      // post the results
      $('#list').append(output);
    }

    function event_submit_button(evt)
    {
        $(".btn-submit").click( function()
        {
            $(".btn-submit").html(spinner());
            $(this).attr("disabled","disabled");
            Load_array(main_file);
        });
    }

    function spinner() 
    {
      return '<i class="fa fa-spinner fa-pulse fa-fw"></i><span class="sr-only">Loading...</span>';
    }

    function Load_array(file) {
      var reader = new FileReader();
      reader.readAsText(file);

      reader.onload = function(event){
        var csv = event.target.result;
        var data = $.csv.toObjects(csv);
        
        console.log(data[ctr]);
        submit_data(data[ctr]);
        // console.log(data);

      };
      reader.onerror = function(){ alert('Unable to read ' + file.fileName); };
    }

    function submit_data(value)
    {
        token = $(".token").val();

        $.ajax(
        {
            url:'/member/item/import/read-file',
            datatype:'json',
            type:'post',
            data: {
              _token:token,
              value:value
            },
            success: function(data)
            {

            },
            error: function(e)
            {
                console.log(e.error());
            }

        });
    }
}