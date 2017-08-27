import { Component } from '@angular/core'
import { GithubService } from '../../services/api/github-service'

@Component({
  selector: 'home',
  templateUrl: 'home.html'
})
export class Home {
  private githubService: GithubService;
  public redirectUrl: string;
  
  constructor(githubService: GithubService) {
    this.githubService = githubService;  
    
    this.githubService.getRedirectUrl().subscribe((url: string) => {
      this.redirectUrl = url;
    });

  }


}