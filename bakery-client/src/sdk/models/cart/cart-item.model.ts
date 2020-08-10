import { ProductModel } from '../product/product.model';

export class CartItemModel {
  public CartId: string | null = null;
  public ProductId: string | null = null;
  public Quantity: number = 0;
  public Product = new ProductModel();

  constructor(data?: Partial<CartItemModel>) {
    Object.assign(this, data);
  }
}
