export abstract class BaseModel {
  
  abstract getTable(): string;

  id?: number;
  
}