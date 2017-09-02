import { Component, OnInit } from '@angular/core';
import { Router, Params } from '@angular/router';
import { GithubService } from '../../services/api/github-service';

@Component({
  selector: 'login',
  templateUrl: 'login.html'
})

export class Login implements OnInit {
  private githubService: GithubService;
  private router: Router;
  public redirectUrl: string;
  public user;

  constructor(githubService: GithubService, router: Router) {
    this.githubService = githubService;
    this.router = router;
  }

  ngOnInit() {
    const code: string = this.router.routerState.snapshot.root.queryParams['code'];
    console.log('checking for code ', code);
    this.githubService.exchangeCode(code)
      .subscribe((user) => {
        this.user = user;
      });
  }
};
