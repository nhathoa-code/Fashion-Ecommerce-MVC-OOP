class Shopping_Cart {
  constructor(items) {
    this.bag = items;
  }

  addToCart(product) {
    if (this.checkExist(product)) {
      let item = this.getItem(product);
      item.quantity += product.quantity;
    } else {
      this.bag.push(product);
    }
  }

  checkExist(product) {
    let item = this.bag.find(
      (item) =>
        item.product_id === product.product_id &&
        item.size === product.size &&
        item.color === product.color
    );
    return item;
  }

  getItem(product) {
    return this.bag.find(
      (item) =>
        item.product_id === product.product_id &&
        item.size === product.size &&
        item.color === product.color
    );
  }

  getItemById(id) {
    return this.bag.find((item) => item.id === id);
  }

  countItems() {
    let totalItem = 0;
    this.bag.forEach((item) => {
      totalItem += item.quantity;
    });
    return totalItem;
  }

  getItems() {
    return this.bag;
  }

  updateItem(id, new_quantity) {
    let item = this.bag.find((item) => item.id === id);
    item.quantity = new_quantity;
  }

  deleteItem(id) {
    this.bag = this.bag.filter((item) => item.id !== id);
  }

  getSubtotal() {
    let subtotal = 0;
    this.bag.forEach((item) => {
      subtotal += item.quantity * item.unit_price;
    });
    return subtotal;
  }

  reset() {
    this.bag = [];
  }
}

export default Shopping_Cart;
