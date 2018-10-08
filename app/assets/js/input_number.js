	const quantityInput = document.querySelectorAll(`input[id^="input"]`);

	quantityInput.forEach((ele) => {
		const id = ele.id.replace('input', '');
		ele.previousSibling.addEventListener("click", () => decrement(id))
		ele.nextSibling.addEventListener("click", () => increment(id))
		ele.addEventListener("blur", () => qtychange(id))
	})

	const decrement = (id) => {
		const val = document.querySelector(`#input${id}`);
		if (val.value >= 2) {
			val.value--
			updateCart(id, val.value)
		}
	}
	const increment = (id) => {
		const val = document.querySelector(`#input${id}`);
		val.value++	
		updateCart(id, val.value)
	}
	const qtychange = (id) => {
		const val = document.querySelector(`#input${id}`)
		updateCart(id, val.value)
	}