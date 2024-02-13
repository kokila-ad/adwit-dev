var myDocument = app.documents.add();
                            // set in inches
                            myDocument.pages.everyItem().resize(CoordinateSpaces.INNER_COORDINATES,AnchorPoint.CENTER_ANCHOR,ResizeMethods.REPLACING_CURRENT_DIMENSIONS_WITH,[72*11.625,72*21]);
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
                                myTextFrame.contents = "Do some sort of BLACK FRIDAY BLOWOUT or whatever you want for the theme.  \r\nMake sure to include \"We will deliver to you\"  in there somewhere\r\nAnd be sure to include \"Family owned and operated for 45 years and counting\"\r\nThe following specials will be for new cars and trucks.\r\nAll New 2021 Tahoes and Yukons arriving daily\r\nuse all three of these pictures for the tahoes and yukons.\r\n\r\nGet 0% for up to 84 months on most 2020 Buick and GMC Suvs.  \r\nput an asterisk and this in fine print  \"*for well qualified buyers\"\r\n\r\nAll New 2021 Chevy Trailblazer RS\r\n2020 Chevy Silverado LT - $41,995 after rebates\r\n2020 Chevy Silverado LT - DEMO $38,995 after rebates\r\n2021 GMC SIERRA - SLT - $49,595 after rebates\r\nThat is all for new.  I will now send a couple of emails with used and be done.";