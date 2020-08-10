export class LoginModel {
  public Email: string | null = null;
  public Password: string | null = null;

  constructor(data?: Partial<LoginModel>) {
    Object.assign(this, data);
  }
}
