var myDocument = app.documents.add();
                            // set in inches
                            myDocument.pages.everyItem().resize(CoordinateSpaces.INNER_COORDINATES,AnchorPoint.CENTER_ANCHOR,ResizeMethods.REPLACING_CURRENT_DIMENSIONS_WITH,[72*3,72*8]);
                            myDocument.viewPreferences.horizontalMeasurementUnits = MeasurementUnits.inches;  
                            myDocument.viewPreferences.verticalMeasurementUnits = MeasurementUnits.inches;
                                
                            for(var j =0;j<myDocument.pages.length;j++)  
                            { 
                                
                                // gather data
                                var pageW=myDocument.documentPreferences.pageWidth;  
                                var pageH=myDocument.documentPreferences.pageHeight;  
                                
                                alert('pageH : '+pageH+ ' | pageW : '+pageW);
                            }
                            var myTextFrame = myDocument.pages.item(0).textFrames.add();
                                myTextFrame.geometricBounds = ['6p', '6p', '24p', '24p'];
                                myTextFrame.contents = "Please use your ad #119039 as a template with these changes:\r\n\r\nmake a big starburst that says: \r\n\r\nKids! Send Your Letters to Santa!\r\nLetters Will be Published on December 23\r\n(deadline - must be received by 12\/16)\r\n\r\nRemove \"& Christmas Greetings\"\r\n\r\nremove \"you don't...24th\"\r\n\r\nremove \"contact...today!\"\r\n\r\nchange the phone number to 717-307-2430 \u2022 13 N. Main St, Mercersburg, PA 17236";