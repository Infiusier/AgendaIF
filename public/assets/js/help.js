$(document).ready(function(){
	$(".i-need-a-help").click(function(){
		var tour = new Tour({
			steps: [
				{
					element: "#catalog",
					title: "O Modulo Catalogo",
					content: "Modulo resposta"
				},
				{
					element: "#my-other-element",
					title: "Title of my step",
					content: "Content of my step"
				}
			],
			template: "<div class='popover tour'>\
					    <div class='arrow'></div>\
					    <h3 class='popover-title'></h3>\
					    <div class='popover-content'></div>\
					    <div class='popover-navigation'>\
					        <button class='btn btn-default' data-role='prev'>« Anterior</button>\
					        <span data-role='separator'>|</span>\
					        <button class='btn btn-default' data-role='next'>Próxiomo »</button>\
					    </div>\
					    <button class='btn btn-default' data-role='end'>Finalizar Tour</button>\
					  </div>"
		});

		// Initialize the tour
		tour.init();

		// Start the tour
		tour.start();
	})
})