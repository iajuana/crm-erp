export class AuthModel {
  authToken: string;
  refreshToken: string;
  expiresIn: Date;
  access_token: AuthModel;

  setAuth(auth: AuthModel) {
    this.authToken = auth.authToken;
    this.refreshToken = auth.refreshToken;
    this.expiresIn = auth.expiresIn;
  }
}
