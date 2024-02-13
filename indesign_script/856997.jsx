var myDocument = app.documents.add();
                            // set in inches
                            myDocument.pages.everyItem().resize(CoordinateSpaces.INNER_COORDINATES,AnchorPoint.CENTER_ANCHOR,ResizeMethods.REPLACING_CURRENT_DIMENSIONS_WITH,[72*5.26,72*5.182]);
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
                                myTextFrame.contents = "please be creative using similar layout.\r\nmake text crisp\r\nchange hours in coupon to\r\nOpen Wed-Fri 10am-6pm\r\nSat 11am-5pm\r\nretypeset this line in 2 places: Consignment and Resale Boutique Formal and Informal Apparel\r\n\r\nExpires 12\/31\/2020\r\n\r\nkeep all the rest of the text in last ad attached but you'll have to change around the words because the photo is more horizontal";