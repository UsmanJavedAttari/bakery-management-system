export class ProductModel {
  public Id: string | null = null;
  public Title: string | null = null;
  public Description: string | null = null;
  public Price: number = 0;
  public Quantity: number = 0;
  public ProductCategoryId: string | null = null;

  constructor(data?: Partial<ProductModel>) {
    Object.assign(this, data);
  }
}
