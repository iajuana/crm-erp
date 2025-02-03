import { Component } from '@angular/core';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
import { CreateRolesComponent } from '../create-roles/create-roles.component';

@Component({
  selector: 'app-list-roles',
  templateUrl: './list-roles.component.html',
  styleUrls: ['./list-roles.component.scss']
})
export class ListRolesComponent {

  // Inject NgbModal service correctly
  constructor(private modalService: NgbModal) {}

  ngOnInit(): void {
    // Initialization logic (if needed)
  }

  // Correct method name to match the template
  createRole() {
    // Open the modal
    const modalRef = this.modalService.open(CreateRolesComponent, { centered: true, size: 'md' });
  }
}
