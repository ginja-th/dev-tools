import { BaseModel } from "./base-model";

export class Collaborator extends BaseModel {
  
  email: string;
  github_username: string;
  slack_username: string;
  is_active: boolean;
  created_at: string; // Date?
  updated_at: string; // Date?

  getTable(): string {
    return 'collaborators';
  }
};