var myDocument = app.documents.add();
                            // set in inches
                            myDocument.pages.everyItem().resize(CoordinateSpaces.INNER_COORDINATES,AnchorPoint.CENTER_ANCHOR,ResizeMethods.REPLACING_CURRENT_DIMENSIONS_WITH,[72*3.48,72*4]);
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
                                myTextFrame.contents = "Customized Medications for Children: Turning Yuck to Yum!\r\n \r\nChildren pose multiple challenges when it comes to medicine. The sensation of taste and texture in the mouth may trigger negative responses in children with Sensory Processing Disorder (SPD) and can produce gagging, vomiting, and screaming, which obviously make it difficult to take medication as prescribed. We can help children with SPD which often accompanies developmental disorders such as autism, fragile X syndrome, and attention-deficit hyperactivity disorder (ADHD). For children who don\u2019t like the taste, color, or texture of their medication, or who have food allergies and specific dietary needs, we can compound customized medications to meet each child\u2019s specific needs including flavored suspensions, gummies, or lollipops, and topical or transdermal creams or gels that eliminate the need to administer medication orally. \r\n";