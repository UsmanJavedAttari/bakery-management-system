import { CartItemModel } from './cart-item.model';

export class CartModel {
  public Id: string | null = null;
  public CustomerId: string | null = null;
  public CartItems: Array<CartItemModel> = [];

  constructor(data?: Partial<CartModel>) {
    Object.assign(this, data);
  }
}
