var myDocument = app.documents.add();
                            // set in inches
                            myDocument.pages.everyItem().resize(CoordinateSpaces.INNER_COORDINATES,AnchorPoint.CENTER_ANCHOR,ResizeMethods.REPLACING_CURRENT_DIMENSIONS_WITH,[72*4.887,72*10]);
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
                                myTextFrame.contents = "Pickup ad #11439334\r\nFollow instructions on layout PDF - attached\r\nDoc file - attached\r\nPics (8) atatched";