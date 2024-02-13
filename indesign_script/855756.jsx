var myDocument = app.documents.add();
                            // set in inches
                            myDocument.pages.everyItem().resize(CoordinateSpaces.INNER_COORDINATES,AnchorPoint.CENTER_ANCHOR,ResizeMethods.REPLACING_CURRENT_DIMENSIONS_WITH,[72*3.16,72*3]);
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
                                myTextFrame.contents = 'Norm Krauss
During this time of sorrow we learn how much our family & friends mean to us! 
We wish to acknowledge the many expressions of love, concern and compassion from friends and loved ones during this time of bereavement.  Special thank you to:
* The staff and doctors at the General & Pasqua Hospitals and Dr. Carulei and staff at the Assiniboia Union Hospital 
* Homecare services including Nadine Stevenson, Christine Printz and their amazing staff for their excellent care while Norm was at home. 
* Wes & Connie Staruiala for your wonderful friendship and support. Your home became my "Home Away from Home" during the weeks we spent in Regina. 
* Shirley Pickard, Clara Ellert & Ralph Krauss for all of your incredible support during & after Norm's illness.
* Father Clement Amofah, Diane Rhodes, Carol Marit & Leon Banadyga for the wonderful service & music.
* The Community Choir for the beautiful floral arrangement where Norm's love of music shone so brightly.
* Anette Pryce and Gary Miller from Ross Funeral Home, whose guidance and expertise made our loss a little more bearable.
* To everyone who travelled from out of town, made phone calls and who sent flowers, food, cards and gifts during this difficult time.
Words cannot express the strength you have given us during these most difficult times. May Norm's bright spirit live on in us all!
Holly, Dana, Tracey, Erin (Scott), Pam ( Simon), Bryan ( Brittany), Dwayne (Chevon) and Papa's Grandkids.
*';