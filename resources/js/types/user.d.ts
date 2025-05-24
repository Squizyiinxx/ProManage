import { User } from '@/types';
export interface UserForm extends User<string> {
    errors: User;
    post: (url: string) => void;
}
