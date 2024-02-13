var myDocument = app.documents.add();
                            // set in inches
                            myDocument.pages.everyItem().resize(CoordinateSpaces.INNER_COORDINATES,AnchorPoint.CENTER_ANCHOR,ResizeMethods.REPLACING_CURRENT_DIMENSIONS_WITH,[72*10,72*21.57]);
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
                                myTextFrame.contents = "source from remax data base ...please always use the most recently used  properties 6003B-6 Ave pic 6101\r\nLease space in a great location. Total area of 3600 sq ft with a 2400 sq ft (40' wide x 60' Long) shop with 2 Overhead doors 12'wide x 14' high with brand new electric door openers, plus 1200 sq ft (30'deep x 40'wide) office space with a upper mezzanine of the same foot print. Front office area is Rooftop Heat with A\/C and the shop area has Radiant heat with ceiling fans. The yard area is fully fenced with 6' chain link with barb wire and is shared space with other tenants. They do have available small fenced separate compound area(60'x40') if further security is needed. The lease is $2400 triple net and the complex is the middle with the Red Arch.  Call Dale\r\n\r\n5612-55 Street pic2768\r\nSuper nice 3 bedroom home in a great area. The main level has 1236 sq ft hosting a great kitchen with granite counters, nice eating area, bright living room, 3 bedrooms and a 4 pc bath. The basement has another bathroom, family room, recreation room, children's play area and laundry. Other bonus are central A\/C, U\/G sprinklers in the back yard and a new 23m Duroshield silicone roof coating with a 10 year warranty. This home shows pride of ownership inside and out plus a huge back yard for the family to have fun together. Perfect location as close to all schools and the home has great eye appeal.  Call DaleRemax";