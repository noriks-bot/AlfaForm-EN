(function () {

    "use strict";

    // Get elements - Start -------------------------------------------------------------------------------------------.

	const inspector   = document.getElementById( "daexthrmal-tag-inspector__wrapper" );
	const expandBtn   = document.getElementById( "daexthrmal-tag-inspector__header-wrapper-right-expand" );
	const collapseBtn = document.getElementById( "daexthrmal-tag-inspector__header-wrapper-right-collapse" );
	const content     = document.getElementById( "daexthrmal-tag-inspector__content" );
	const footer      = document.getElementById( "daexthrmal-tag-inspector__footer" );

    // Get elements - End ---------------------------------------------------------------------------------------------.

	// Exit if the inspector element does not exist.
	if (!inspector) {
		return;
	}

    // Set the initial position of the tag inspector - Start ----------------------------------------------------------.

	const updatePosition           = () => {
		const inspectorHeight      = inspector.offsetHeight; // Get the actual height of the element.
		const topValue             = window.innerHeight - 24 - inspectorHeight; // Calculate dynamic top value.
		inspector.style.top        = `${topValue}px`; // Apply the calculated top value.
		inspector.style.visibility = "visible"; // Make the element visible after positioning.
	};

	// Initial position update.
	updatePosition();

    // Set the initial position of the tag inspector - End ------------------------------------------------------------.

    // Handle the expand/collapse functionality - Start ---------------------------------------------------------------.

	// Collapse button.
	expandBtn.addEventListener(
		"click",
		() => {
			content.style.display     = "block";
			footer.style.display      = "flex";
			expandBtn.style.display   = "none";
			collapseBtn.style.display = "block";
		}
	);

	// Collapse button.
	collapseBtn.addEventListener(
		"click",
		() => {
			content.style.display     = "none"
			footer.style.display  = "none";
			expandBtn.style.display   = "block";
			collapseBtn.style.display = "none";
		}
	);

    // Handle the expand/collapse functionality - End -----------------------------------------------------------------.

    // Handle dragging of the inspector - Start -----------------------------------------------------------------------.

	// Dragging.
	let isDragging = false, offsetX, offsetY;
	const header   = inspector.querySelector( ".daexthrmal-tag-inspector__header" );

	header.addEventListener(
		"mousedown",
		(e) => {
			isDragging                     = true;
			offsetX                        = e.clientX - inspector.offsetLeft;
			offsetY                        = e.clientY - inspector.offsetTop;
			document.body.style.userSelect = "none";
		}
	);

	document.addEventListener(
		"mousemove",
		(e) => {
			if (isDragging) {
				inspector.style.left = (e.clientX - offsetX) + "px";
				inspector.style.top  = (e.clientY - offsetY) + "px";
			}
		}
	);

	document.addEventListener(
		"mouseup",
		() => {
			isDragging                     = false;
			document.body.style.userSelect = "auto";
		}
	);

    // Handle dragging of the inspector - End -------------------------------------------------------------------------.

    // Handle the switching between table view and tag view - Start ---------------------------------------------------.

	// Mode switching.
	document.getElementById( "daexthrmal-tag-inspector__table-view-btn" ).addEventListener(
		"click",
		() => {
			document.getElementById( "daexthrmal-tag-inspector__table-view" ).style.display = "block";
			document.getElementById( "daexthrmal-tag-inspector__tag-view" ).style.display   = "none";
			// Update the pills buttons. (add active class to table view button, remove from tag view button).
			document.getElementById( "daexthrmal-tag-inspector__table-view-btn" ).classList.add( "daexthrmal-tag-inspector__table-view-btn-active" );
			document.getElementById( "daexthrmal-tag-inspector__tag-view-btn" ).classList.remove( "daexthrmal-tag-inspector__tag-view-btn-active" );
		}
	);

	document.getElementById( "daexthrmal-tag-inspector__tag-view-btn" ).addEventListener(
		"click",
		() => {
			document.getElementById( "daexthrmal-tag-inspector__table-view" ).style.display = "none";
			document.getElementById( "daexthrmal-tag-inspector__tag-view" ).style.display   = "block";
			// Update the pills buttons. (add active class to tag view button, remove from table view button).
			document.getElementById( "daexthrmal-tag-inspector__table-view-btn" ).classList.remove( "daexthrmal-tag-inspector__table-view-btn-active" );
			document.getElementById( "daexthrmal-tag-inspector__tag-view-btn" ).classList.add( "daexthrmal-tag-inspector__tag-view-btn-active" );
		}
	);

    // Handle the switching between table view and tag view - End -----------------------------------------------------.

})();
