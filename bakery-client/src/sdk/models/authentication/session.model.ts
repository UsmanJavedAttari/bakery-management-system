import { SignupModel } from './signup.model';
import { CartModel } from '../cart/cart.model';

export class SessionModel {
  public Id: string | null = null;
  public DisplayName: string | null = null;
  public Email: string | null = null;
  public CartId: string | null = null;

  constructor(data?: Partial<SessionModel>) {
    Object.assign(this, data);
  }
}
