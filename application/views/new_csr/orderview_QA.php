<html lang="en" class="no-js">
    <title>CSR | Adwitads</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="" name="description">
    <meta content="" name="author">
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <base href="<?php echo base_url();?>" />
    
    <body>

<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<!-- BEGIN PAGE HEAD -->
	<!-- END PAGE HEAD -->
	<!-- BEGIN PAGE CONTENT -->
	<div class="page-content">
		<div class="container">
	        <div id="adobe-dc-view" style="width:100%;height:100%;"></div>
		</div>
	</div>
	<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->


<!-- pdf annotation -->
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>

<script src="https://documentcloud.adobe.com/view-sdk/main.js"></script> 

<script type="text/javascript">

	document.addEventListener("adobe_dc_view_sdk.ready", function(){ 

		var adobeDCView = new AdobeDC.View({clientId: "9962a6efddab4b0391adc0fd311e55ab", divId: "adobe-dc-view"});

		adobeDCView.previewFile({

			//content:{location: {url: "<%=pdfName%>"}},

			content:{location: {url: "<?php echo $pdf_annotation_url; ?>"}},

			//content:{location: {url: "https://documentcloud.adobe.com/view-sdk-demo/PDFs/Bodea Brochure.pdf"}},

			metaData:{fileName: "<?php echo $pdf_name; ?>"},
			
			defaultViewMode: "FIT_PAGE"

		}, {});//IN_LINE

	/* Register save callback */ 

        adobeDCView.registerCallback(

            AdobeDC.View.Enum.CallbackType.SAVE_API,

            function (metaData, content, options) {

                console.log(metaData);

                console.log(content);

                

                var base64PDF = arrayBufferToBase64(content);

                var formData = new FormData();

                formData.append('content', base64PDF);

                

                $.ajax({  

		  		       url : "<?php echo base_url().index_page().'new_csr/home/csr_pdf_review/'.$orders['id']; ?>",  

		  		       type : 'POST',

		  		     enctype: 'multipart/form-data',

		  		     data: formData,

		  		   processData: false,

		            contentType: false,

		            cache: false,

		            timeout: 600000, 

		  		   success : function(response) {

		  			//console.log(response);

		  		   }

				});

                

				console.log('Uploaded a file!');

				

                return new Promise(function (resolve, reject) {

                    /* Dummy implementation of Save API, replace with your business logic */

                    setTimeout(function () {

                        var response = {

                            code: AdobeDC.View.Enum.ApiResponseCode.SUCCESS,

                            data: {

                                metaData: Object.assign(metaData, { updatedAt: new Date().getTime() })

                            },

                        };

                        resolve(response);

                    }, 2000);

                });

            }

        );

		

	});


	function arrayBufferToBase64(buffer) {

        var binary = "";

        var bytes = new Uint8Array(buffer);

        var len = bytes.byteLength;

        for (var i = 0; i < len; i++) {

            binary += String.fromCharCode(bytes[i]);

        }

        return window.btoa(binary);

    }

</script>
 <!--pdf annotation END-->
 </body>
</html>