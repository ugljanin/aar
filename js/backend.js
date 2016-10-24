/*
		CONFIGURATION FUNCTIONS
*/

var nizobjekata = [];
var unique;
var chart;
var nizall = [];

function loadDefaults() {
	$("#expense-vh").val("50");
	$("#expense-hi").val("25");
	$("#expense-low").val("-25");
	$("#expense-vl").val("-50");

	$("#income-vh").val("50");
	$("#income-hi").val("25");
	$("#income-low").val("-25");
	$("#income-vl").val("-50");

	$("#profit-vh").val("50");
	$("#profit-hi").val("25");
	$("#profit-low").val("-25");
	$("#profit-vl").val("-50");
}

function loadConfigData(config) {
	if (!config || config.length === 0) return;

	var values = config.split(';');

	$.each(values, function(key, val) {
		var item = val.split(':');
		var fieldId = $.trim(item[0]);
		var fieldVal = $.trim(item[1]);

		$("#" + fieldId).val(fieldVal);
	});
}

/*
		COMPUTATION FUNCTIONS
*/

function getScenarioType() {
	var scenario = $('input[name=scenario]').val();
	if (["B", "I", "D"].indexOf(scenario) > -1) return scenario;
	else return "?";
}

function getResourceProperties() {
	var properties = $('input[name=properties]').val();
	if (["L", "U", "R"].indexOf(properties) > -1) return properties;
	else return "?";
}

function getTaskType() {
	var task = $('input[name=task]').val();
	if (["P", "C", "R"].indexOf(task) > -1) return task;
	else return "?";
}

function getNumericValue(fieldId) {
	var val = $("#" + fieldId).val();
	console.log("get numeric value "+val+" polje #"+fieldId);
	if (val) return parseFloat(val);
	else return 0;
}

function valueMapping(kind, value) {
	if (["expense", "income", "profit"].indexOf(kind) < 0) return "Unknown";

	var vh = getNumericValue(kind + "-vh");
	var hi = getNumericValue(kind + "-hi");
	var low = getNumericValue(kind + "-low");
	var vl = getNumericValue(kind + "-vl");

	if (value >= vh) return "Very High";
	if (value >= hi) return "High";
	if (value > low) return "Medium";
	if (value > vl) return "Low";
	return "Very Low";
}

/*
		THE MAIN CALCULATION ROUTINE
*/

function calculate() {
	var result = 0;
	var scenario = getScenarioType();
	var resources = getResourceProperties();
	var task = getTaskType();

	console.log("Profit - Scn: " + scenario + ", Res: " + resources + ", Task: " + task);

	switch (scenario) {
		case "B":
			if (resources == "L") {
				result = getNumericValue("income_mi") +
					getNumericValue("income_mj") - getNumericValue("expense_mj");
			}
			else {
				result = getNumericValue("income_mi") + getNumericValue("income_mj");
			}
			break;
	}

	return result;
}

/*
		USER INTERFACE FUNCTIONS
*/
	//var scenario = $('input[name=scenario]:checked').val();
	var scenario = 'B';
	var resources = 'L';
	//var resources = $('input[name=properties]:checked').val();
	var task = $('input[name=task]:checked').val();
function updateInterface() {
	console.log("promena");
	scenario = $('input[name=scenario]:checked').val();
	resources = $('input[name=properties]:checked').val();
	task = $('input[name=task]:checked').val();

	$("#m_mapping_expense").val("");
	$("#m_mapping_income").val("");

	if(scenario=="B")
	{
		$("#machinesmanual").show();
		$("#peoplemanual").hide();
		$("#tasksmanual").hide();
		$("#machinesauto").show();
		$("#peopleauto").hide();
		$("#tasksauto").hide();

		$("#pivot").prop('disabled', true);
		$("#compensatable").prop('disabled', true);
	}
	else if(scenario=="I")
	{
		$("#machinesmanual").hide();
		$("#peoplemanual").hide();
		$("#tasksmanual").show();

		$("#machinesauto").hide();
		$("#peopleauto").hide();
		$("#tasksauto").show();


		$("#pivot").prop('disabled', false);
		$("#compensatable").prop('disabled', false);
	}
	else if(scenario=="D")
	{
		$("#machinesmanual").hide();
		$("#peoplemanual").show();
		$("#tasksmanual").hide();
		$("#machinesauto").hide();
		$("#peopleauto").show();
		$("#tasksauto").hide();

		$("#pivot").prop('disabled', false);
		$("#compensatable").prop('disabled', false);
	}

	console.log("UI - Scn: " + scenario + ", Res: " + resources + ", Task: " + task);
	if($('#unlimited').is(':checked'))
	{
		console.log("checked unlimited");
		$("#expense-mj").prop('disabled', true);
	}
	else
		$("#expense-mj").prop('disabled', false);
	$("#income-mj-input").hide();
	$("#expense-mj-input").hide();



	switch (scenario) {
		case "B":
			$("#income-mj-input").show();
			if (resources == "L") $("#expense-mj-input").show();
			break;
	}
}

/*
		CALLBACK REGISTRATION
*/
function randomIntFromInterval(min,max)
{
    return Math.floor(Math.random()*(max-min+1)+min);
}

$("#button-defaults").click(function() { loadDefaults(); });
$('#m-button-calculate').on('click', function(e) {
	if($("#machinesform").valid())
	{
		e.preventDefault();
		var profit = calculate();

		$("#m_mapping_income").val(valueMapping("income", profit) + " (" + profit.toString() + ")");
	}
});

function range(start, end) {
    var foo = [];
    for (var i = start; i < end; i++) {
        foo.push(i);
    }
    return foo;
}
function rangeReverse(start, end) {
    var foo = [];
    for (var i = start; i > end; i--) {
        foo.push(i);
    }
    return foo;
}
function isInArray(value, array) {
  return array.indexOf(value) > -1;
}
function getRandom(arr, n) {
    var result = new Array(n),
        len = arr.length,
        taken = new Array(len);
    if (n > len)
	throw new RangeError("getRandom: more elements taken than available");
    while (n--) {
        var x = Math.floor(Math.random() * len);
        result[n] = arr[x in taken ? taken[x] : x];
        taken[x] = --len;
    }
    return result;
}
function array_rand (input, num_req) {
  // http://kevin.vanzonneveld.net
  // +   original by: Waldo Malqui Silva
  // *     example 1: array_rand( ['Kevin'], 1 );
  // *     returns 1: 0
  var indexes = [];
  var ticks = num_req || 1;
  var checkDuplicate = function (input, value) {
    var exist = false,
      index = 0,
      il = input.length;
    while (index < il) {
      if (input[index] === value) {
        exist = true;
        break;
      }
      index++;
    }
    return exist;
  };

  if (Object.prototype.toString.call(input) === '[object Array]' && ticks <= input.length) {
    while (true) {
      var rand = Math.floor((Math.random() * input.length));
      if (indexes.length === ticks) {
        break;
      }
      if (!checkDuplicate(indexes, rand)) {
        indexes.push(rand);
      }
    }
  } else {
    indexes = null;
  }

  return ((ticks == 1) ? indexes.join() : indexes);
}
$('#auto_button_calculate').on('click', function(e) {
	e.preventDefault();

	var unique=new Date().getTime();
	var niz = [];
	var objchart=[];
	var nizmaster = [];
	var nizslave = [];
	var nizobjekata = [];
	var nizrejected = [];
	var nizgoodwill = [];
	var nizar = [];
	var nizma = [];
	var nizselfishness = [];
	var nizother = [];
	var fromrange=$("#fromrange").val();
	var torange=$("#torange").val();
	var from=$("#from").val();
	var to=$("#to").val();
	var loop=$("#loop").val();
	var mam1=parseInt($("#mam1").val());
	var mam2=parseInt($("#mam2").val());
	var mam3=parseInt($("#mam3").val());
	var mam4=parseInt($("#mam4").val());
	var mam5=parseInt($("#mam5").val());
	var arm1=parseInt($("#arm1").val());
	var arm2=parseInt($("#arm2").val());
	var arm3=parseInt($("#arm3").val());
	var arm4=parseInt($("#arm4").val());
	var arm5=parseInt($("#arm5").val());
	nizar.push(arm1);
	nizar.push(arm2);
	nizar.push(arm3);
	nizar.push(arm4);
	nizar.push(arm5);
	nizma.push(mam1);
	nizma.push(mam2);
	nizma.push(mam3);
	nizma.push(mam4);
	nizma.push(mam5);

	$("#machinesbody").html("");
	var autoincomemj=randomIntFromInterval(from,to);
	var autoexpensemj=randomIntFromInterval(from,to);

	var profitmj = autoincomemj - autoexpensemj;
	var gainmj = (((autoincomemj/autoexpensemj)-1) *100).toFixed(2);


	var objmj={};
	objmj["name"]="Mj";
	objmj["income"]=autoincomemj;
	objmj["expense"]=autoexpensemj;
	objmj["profit"]=profitmj;
	objmj["gain"]=gainmj;
	nizmaster.push(objmj);


	var row="<tr id="+i+"><td>Mj</td><td>"+autoincomemj+"</td><td>"+autoexpensemj+"</td><td>"+profitmj+"</td><td>"+gainmj+"%</td></tr>";
	$("#machinesbodymi").html(row);
	//console.log("From "+from+" to "+to+" loop "+loop+" income mj "+autoincomemj+" income mi "+autoincomemi);

	switch (scenario) {
		case "B":
			if (resources == "L") {

				for(var i=0;i<5;i++)
				{

					var classhtml;
					var autoincomemi=randomIntFromInterval(from,to);
					var autoexpensemi=randomIntFromInterval(from,to);

					var gainmi = (((autoincomemi/autoexpensemi)-1) *100).toFixed(2);
					//var profitmi = autoincomemj+autoincomemi - autoexpensemi;
					var profitmi = autoincomemi - autoexpensemi;
					if(gainmi>nizar[i])
					{

						var obj={};
						obj["id"]=i;
						obj["name"]="M"+(i+1);
						obj["income"]=autoincomemi;
						obj["expense"]=autoexpensemi;
						obj["profit"]=profitmi;
						obj["gain"]=gainmi;
						obj["ma"]=nizma[i];
						obj["ar"]=nizar[i];
						obj["status"]="Accept";
						nizobjekata.push(obj);
						nizslave.push(obj);

							classhtml="";
							var rejected="";
					}
					else
					{

						var rejected={};
						rejected["id"]=i;
						rejected["name"]="M"+(i+1);
						rejected["income"]=autoincomemi;
						rejected["expense"]=autoexpensemi;
						rejected["profit"]=profitmi;
						rejected["gain"]=gainmi;
						rejected["ma"]=nizma[i];
						rejected["ar"]=nizar[i];
						rejected["status"]="Reject";

						nizrejected.push(rejected);

						nizslave.push(rejected);
						classhtml="selfishness";

						var rejected="Rejected";
					}
					//treba mi lista svih mi masina bez obzira na to jesul prihvacene ili ne



					var nm=i+1;

					var row="<tr id="+i+" data-machine="+nm+" class="+classhtml+"><td>M"+nm+"</td><td>"+autoincomemi+"</td><td>"+autoexpensemi+"</td><td>"+profitmi+"</td><td>"+gainmi+"%</td><td class=\"newgain\"></td><td>"+nizar[i]+"%</td><td>"+nizma[i]+"%</td><td class=\"quality\">"+rejected+"</td></tr>";
					$("#machinesbody").append(row);
				}
			}
			else {
				profitmi = autoincomemi + autoincomemj;
			}
			break;
	}
	$("#machineslog").html("");
	var reject;
	for(reject in nizrejected)
	{
		$("#machineslog").prepend("<li>Machine "+nizrejected[reject].name+" is rejected by AR");
	}

	if(nizobjekata.length>0)
	{
		var elementi=getRandom(nizobjekata, 1)
		var selected=elementi[0].id;
		$("#"+selected).addClass("goodwill");
		$("#"+selected).find("td.quality").html("<select class=\"qlt\" data-id="+selected+"><option value=\"Neutral\">Neutral</option><option value=\"Selfishness\">Selfishness</option><option value=\"Goodwill\">Goodwill</option></select>");

		$("#machineslog").append("<li>Machine selected for the job is "+elementi[0].name);

		var newprofitmi = autoincomemj+elementi[0].income - elementi[0].expense;
		var newgainmi = ((((elementi[0].income+autoincomemj)/elementi[0].expense)-1) *100).toFixed(2);



		objchart.push(elementi[0].income);
		objchart.push(elementi[0].expense);
		objchart.push(elementi[0].profit);
		niz.push(objchart);


		$("#"+elementi[0].id+" .newgain").html(newgainmi+"%");

		$("#machineslog").append("<li>Profit for "+elementi[0].name+" was "+elementi[0].profit+" and now is "+newprofitmi);
		$("#machineslog").append("<li>Gain/Loss for "+elementi[0].name+" was "+elementi[0].gain+"% and now is "+newgainmi+"%");

		nizslave[elementi[0].id].gainnew=newgainmi;

		if(nizma[elementi[0].id]<newgainmi)
		{
			console.log(nizma[elementi[0].id]+" "+newgainmi);
			$("#machineslog").append("<li>Machine "+elementi[0].name+" is accepting Mj`s offer");

			if(newprofitmi<0)
			{
				$("#machineslog").append("<li>Machine "+elementi[0].name+" has goodwill");
				nizgoodwill.push(objchart);
				nizslave[elementi[0].id].quality="Goodwill";
				$("#"+elementi[0].id).find("select.qlt").val("Goodwill");
			}
			{
				nizother.push(objchart);
				nizslave[elementi[0].id].quality="Neutral";
				$("#"+elementi[0].id).find("select.qlt").val("Neutral");
			}
		}
		else
		{
			$("#machineslog").append("<li>Machine "+elementi[0].name+" is rejecting Mj`s offer");

			if(newprofitmi>0)
			{
				$("#machineslog").append("<li>Machine "+elementi[0].name+" is selfish");
				nizselfishness.push(objchart);
				nizslave[elementi[0].id].quality="Selfishness";

				$("#"+elementi[0].id).find("select.qlt").val("Selfishness");
			}
			else
			{
				nizother.push(objchart);
				nizslave[elementi[0].id].quality="Neutral";

				$("#"+elementi[0].id).find("select.qlt").val("Neutral");
			}
		}

	}
	else
	{
		$("#machineslog").append("<li>All machines are rejected");
	}
	$(document).ready(function(){


		$.ajax({
			data: {"module":"simulation","simulationid":unique},
			type: 'POST',
			url: 'https://social.connect.rs/WETICE2016/simulation.php',
			beforeSend:function() {
				console.log("salji");
			},
			success:function(response) {

				console.log("response "+response);
			}
		});
		$.ajax({
			data: {"module":"master","income":nizmaster[0].income,"expense":nizmaster[0].expense,"profit":nizmaster[0].profit,"gain":nizmaster[0].gain,"name":nizmaster[0].name,"simulationid":unique },
			type: 'POST',
			url: 'https://social.connect.rs/WETICE2016/simulation.php',
			beforeSend:function() {
				console.log("salji");
			},
			success:function(response) {

				console.log("hocel ");
				console.log("response "+response);
			}
		});

		for(var x in nizslave)
		{
			$.ajax({
				data: {"module":"slave","status":nizslave[x].status,"income":nizslave[x].income,"expense":nizslave[x].expense,"profit":nizslave[x].profit,"gain":nizslave[x].gain,"gainnew":nizslave[x].gainnew,"name":nizslave[x].name,"name":nizslave[x].name,"quality":nizslave[x].quality,"ar":nizslave[x].ar,"ma":nizslave[x].ma,"simulationid":unique },
				type: 'POST',
				url: 'https://social.connect.rs/WETICE2016/simulation.php',
				beforeSend:function() {
					console.log("salji");
				},
				success:function(response) {

					console.log("hocel ");
					console.log("response "+response);
				}
			});
		}


	});


	//console.log(rangev4limit+" cetvrti niz "+v4+" v4 "+positiveLimit+" limit");

	$(function () {

    // Give the points a 3D feel by adding a radial gradient
    Highcharts.getOptions().colors = $.map(Highcharts.getOptions().colors, function (color) {
        return {
            radialGradient: {
                cx: 0.4,
                cy: 0.3,
                r: 0.5
            },
            stops: [
                [0, color],
                [1, Highcharts.Color(color).brighten(-0.2).get('rgb')]
            ]
        };
    });

    // Set up the chart
    chart = new Highcharts.Chart({
        chart: {
            renderTo: 'machineschart',
            margin: 100,
            type: 'scatter',
			exporting: {
            buttons: {
                contextButton: {
                    enabled: false
                },
                exportButton: {
                    text: 'Download',
                    menuItems: Highcharts.getOptions().exporting.buttons.contextButton.menuItems.splice(2)
                },
                printButton: {
                    text: 'Print',
                    onclick: function () {
                        this.print();
                    }
                }
            }
        },
            options3d: {
                enabled: true,
                alpha: 10,
                beta: 30,
                depth: 250,
                viewDistance: 5,

                frame: {
                    bottom: { size: 1, color: 'rgba(0,0,0,0.02)' },
                    back: { size: 1, color: 'rgba(0,0,0,0.04)' },
                    side: { size: 1, color: 'rgba(0,0,0,0.06)' }
                }
            }
        },
        title: {
            text: 'Social quality'
        },
        subtitle: {
            text: 'Click and drag the plot area to rotate in space'
        },
        plotOptions: {
            scatter: {
                width: 10,
                height: 10,
                depth: 10
            }
        },
        yAxis: {
            min: 0,
            max: 200,
			title: {
                text: 'Y-axis Expense',
                align: 'high'
            }
        },
        xAxis: {
            min: 0,
            max: 200,
			title: {
                text: 'X-axis Income',
                align: 'low'
            },
            gridLineWidth: 1
        },
        zAxis: {
            min: -200,
            max: 200,

			title: {
                text: 'Z-axis Profit'
            },
            showFirstLabel: false
        },
        legend: {
            enabled: true
        },
        series: [{
            name: 'Selfishness',
						color: "red",
            data: nizselfishness
        },{
            name: 'Goodwill',
						color: "green",
            data: nizgoodwill
        },{
            name: 'Neutral',
						color: "grey",
            data: nizother
        }]
    });

		//chart.series[0].setData(data,true);

    // Add mouse events for rotation
    $(chart.container).bind('mousedown.hc touchstart.hc', function (eStart) {
        eStart = chart.pointer.normalize(eStart);

        var posX = eStart.pageX,
            posY = eStart.pageY,
            alpha = chart.options.chart.options3d.alpha,
            beta = chart.options.chart.options3d.beta,
            newAlpha,
            newBeta,
            sensitivity = 5; // lower is more sensitive

        $(document).bind({
            'mousemove.hc touchdrag.hc': function (e) {
                // Run beta
                newBeta = beta + (posX - e.pageX) / sensitivity;
                chart.options.chart.options3d.beta = newBeta;

                // Run alpha
                newAlpha = alpha + (e.pageY - posY) / sensitivity;
                chart.options.chart.options3d.alpha = newAlpha;

                chart.redraw(false);
            },
            'mouseup touchend': function () {
                $(document).unbind('.hc');
            }
        });
    });




	 $("select.qlt").on("change",function(){
			var dataid=parseInt($(this).data("id"))+1;
			var qualitym=$(this).val();
			console.log(dataid+" dataid "+qualitym+" qualitym "+unique+" unique");
			console.log("data "+dataid);
			$.ajax({
				data: {"module":"update","simulationid":unique,"quality":qualitym,"machine":dataid},
				type: "POST",
				dataType:"text",
				url: "simulation.php",
				beforeSend:function() {
					console.log("update");
				},
				error: function (jqXHR, exception) {
					console.log(jqXHR.status);
					console.log(exception);
					if (jqXHR.status === 0) {
							console.log('Not connect.\n Verify Network.');
					} else if (jqXHR.status == 404) {
							console.log('Requested page not found. [404]');
					} else if (jqXHR.status == 500) {
							console.log('Internal Server Error [500].');
					} else if (exception === 'parsererror') {
							console.log('Requested JSON parse failed.');
					} else if (exception === 'timeout') {
							console.log('Time out error.');
					} else if (exception === 'abort') {
							console.log('Ajax request aborted.');
					} else {
							console.log('Uncaught Error.\n' + jqXHR.responseText);
					}
			},
				success:function(data) {
					console.log("response update "+data);
					if(qualitym=='Selfishness')
					{
						nizselfishness=[];
						nizgoodwill=[];
						nizother=[];
						nizselfishness.push(objchart);
					}
					else if(qualitym=='Goodwill')
					{
						nizselfishness=[];
						nizgoodwill=[];
						nizother=[];
						nizgoodwill.push(objchart);
					}
					else if(qualitym=='Neutral')
					{
						nizselfishness=[];
						nizgoodwill=[];
						nizother=[];
						nizother.push(objchart);
					}
					console.log(nizselfishness);
					console.log(nizgoodwill);
					console.log(nizother);
					chart.series[0].update({name: 'Selfishness', color: "red", data: nizselfishness} );
					chart.series[1].update({name: 'Goodwill', color: "green", data: nizgoodwill});
					chart.series[2].update({name: 'Neutral', color: "grey", data: nizother});



				}
			});
		});

});

		//console.log("pokreni graf");
		//console.log(all);




});


$("#button-load").click(function() {
	// force the file selector opening
	$("#config-file").click();
});

$("#config-file").change(function(event) {
	// when the config file is selected, do the AJAX call via form submit
	$("#config-load-form").submit();
});

$("#config-load-form").submit(function(event) {
	event.preventDefault();

	var formData = new FormData();
	var fileData = $("#config-file").prop('files')[0];

	formData.append("config-file", fileData);

	$.ajax({
		url: $("#config-load-form").attr("action"),
		cache: false,
		contentType: false,
		processData: false,
		type: "POST",
		data: formData,
		success: function(response) {
			loadConfigData(response);
			//alert("Server said: " + response);
		},
		error: function(e) {
			alert("Error: " + e);
		}
	});
});

/*
		MAIN
*/

$(document).ready(function() {
	$("#machinesauto").show();
	$("#peopleauto").hide();
	$("#tasksauto").hide();
	$("#machinesmanual").show();
	$("#peoplemanual").hide();
	$("#tasksmanual").hide();

	$("#pivot").prop('disabled', true);
	$("#compensatable").prop('disabled', true);



	$('input[name=scenario]').on("change",function() { updateInterface(); });
	$('input[name=properties]').on("change",function() { updateInterface(); });
	$('input[name=task]').on("change",function() { updateInterface(); });


	loadDefaults();
});
