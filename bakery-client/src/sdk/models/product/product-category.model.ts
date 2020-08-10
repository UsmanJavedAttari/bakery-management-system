export class ProductCategoryModel {
  public Id: string | null = null;
  public Title: string | null = null;
  public Description: string | null = null;

  constructor(data?: Partial<ProductCategoryModel>) {
    Object.assign(this, data);
  }
}
