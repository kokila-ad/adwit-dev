var myDocument = app.documents.add();
                            // set in inches
                            myDocument.pages.everyItem().resize(CoordinateSpaces.INNER_COORDINATES,AnchorPoint.CENTER_ANCHOR,ResizeMethods.REPLACING_CURRENT_DIMENSIONS_WITH,[72*10.25,72*20.5]);
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
                                myTextFrame.contents = 'Please follow the same format as attached ad in requested size with the changes and updated pictures of items listed below. 
Also instead of the Now Open in the barrell, can we have it say something like Thanksgiving specials. 
Thanksgiving day hours 9 am - 2pm
Prices Valid 18th-30th

Blue Moon 12 pack bottle $16.99
Keystone Premium 30 pack can $13.99
White Claw Variety #2 12 pack can $17.99
I.C. Light 30 pack can $19.99
Yuengling 12 pack bottles $10.99
Bud & Bud Light 18pk cans $11.99
Sam Adams Winter Lager 12 pack bottle $17.79
NEW Bold Rock Hard Cider Variety 12 pack can $16.79
Clubtails 8 pack Variety $13.49
Busch & Busch Light 30 pack cans $17.79
Corona 24 pack bottle $30.99
Rolling Rock 18 pack can $10.49';