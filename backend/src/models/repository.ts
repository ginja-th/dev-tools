import { BaseModel } from "./base-model";

export class Repository extends BaseModel {
  
  getTable(): string {
    return 'repositories';
  }
};