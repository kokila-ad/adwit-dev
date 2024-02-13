<div id="adobe-dc-view" style="height: 1000px"></div>

Javascript
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>

	

	<script src="https://documentcloud.adobe.com/view-sdk/main.js"></script> 







<script type="text/javascript">

	document.addEventListener("adobe_dc_view_sdk.ready", function(){ 

		var adobeDCView = new AdobeDC.View({clientId: "9962a6efddab4b0391adc0fd311e55ab", divId: "adobe-dc-view"});

		adobeDCView.previewFile({

			//content:{location: {url: "<%=pdfName%>"}},

			content:{location: {url: "https://adwitads.com/weborders/pdf_uploads/917019/917019_41415713_REC_LEFT_PG_1_051421_LH_A_J40_V1.pdf"}},

			//content:{location: {url: "https://documentcloud.adobe.com/view-sdk-demo/PDFs/Bodea Brochure.pdf"}},

			

			metaData:{fileName: "Bodea Brochure.pdf"}

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

		  		       url : '<?php echo base_url().index_page().'cron_jobs/home/order_annotation_content'; ?>',  

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