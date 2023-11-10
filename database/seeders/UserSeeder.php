<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nickname' => 'Mike',
            'email' => 'mike@gmail.com',
            'password' => Hash::make('Mike123.'),
            'name' => 'Miguel',
            'last_name' => 'Tri',
            'address' => 'Monterrey',
            'phone' => '1234567890',
            'image' => '/9j/4AAQSkZJRgABAQEASABIAAD/2wBDAFA3PEY8MlBGQUZaVVBfeMiCeG5uePWvuZHI////////////////////////////////////////////////////2wBDAVVaWnhpeOuCguv/////////////////////////////////////////////////////////////////////////wAARCAGQAZADASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwCKlooqRBRRRTAKSlooASilxRigBKKWigBKKWkoAM0uaSigB2aM02jNADqSkzRTAWjNJRQIWlptLQMWlpKKAFopKKAFpKKcq55PSk2CQyipGIAwBTM0rj5RKKKKoQtFJRmgQ6im5ozQA6kpKKAFpM0UUAGaM0lFAC5ozSUUAOBpabSg0ALRRRQAUUUUAMoFFLSKCiiigQUUlLQAUUUUAFFFFIApKWjFACUUtJQAUUUUAFJTgpNP8rAyTRcdiKpUiLUq4HQUEuelK5VgaLb3pAuOtPVWI5p2McUuYLEeR6UEZ7U/aewp4XjmncLFcigAmpTGe1OWPA5p3FYiCHNShcDFP2ilxSY0QsmelIIeOanxQaQyv5WK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',
            'created_at' => now(),
            'updated_at' => now()
        ])->assignRole(['SuperAdmin']);

        User::create([
            'nickname' => 'Mew',
            'email' => 'mew@review.com',
            'password' => Hash::make('Mew123.'),
            'name' => 'Perla',
            'last_name' => 'Hdz',
            'address' => 'Monterrey',
            'phone' => '1234567890',
            'image' => '/9j/4AAQSkZJRgABAQEASABIAAD/2wBDAFA3PEY8MlBGQUZaVVBfeMiCeG5uePWvuZHI////////////////////////////////////////////////////2wBDAVVaWnhpeOuCguv/////////////////////////////////////////////////////////////////////////wAARCAGaAb4DASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwCsKKKKACkNLSN7UAJRRRQAUUUUAFFFFABSikoNAC5pKKUUAJRS0hoAUUuDTadnjpQA2ig0UAFFFFABRRRQAUUUUAFJS0UAJS0lFAC0UUUAFFFFABRRRQAlFLSUAFFFFABRRRQAUoxSUUAFFJS0AFLSUUAFFFFAC0lKDikoAKKKBQAUUtFABThSYpaACkNL2oHNACYoIpTSUAIaMUtAGaAEoxS4oFAABSkUlLQAGiiigApDS0lABRk0UlABRUyxAjnrTHjK0AMooooAKKWkoAKKKKACiiigAooooAKKKKACiiigAooooAKKKKAEooooAKKKKACiiigAopKWgAooooAKKKKACiiigApRSUtABSUtFADqOe1FGcUAJmgUlLmgANGaQ0UALRSrQaAEpR0opM0ABpQKSl7UAFJQetFAC0UUUAJSoOaQ05KQEyGnHBpi0+gZE0fcVGVIq1TSooArUlTGPmmmOmIjop/lmlEZNAEdFTCKgxUgIaKmMVN8simBHilxUmyk2HOKAGUlSeWacsXHNICGnKhbtU4jHpTuBQBGIlXk01mGcYp7HiojQMRgOoplP9qaaYhKKKKACiiigAooooAKKKKACiiigAooooAKWkpTzQAlLSUUASdqaadSdqAG05cYOaTFFACUCl70UAApTRR2oATrSgUUooAQ0lK3aigBKXtRkUhoAKUUgxiigAp8dMqSMc0gHilzQaSkMcKWminUDDFGKKWmAlLRRSAKKKKYBSUtFIBKTFLRQAUoptGaAHE0wmgmm5piENNNONJigBtMbrUhqNutMQlFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFLSUUAFFLiigB4pCKWkzQAnajFKfakxQAUppAKcaAEopaSgAooooAdikxxQKU5xQAw0UYpcUANpaU9KSgBakjqMVNEKQxxFJTiKSgApaKKQwpaSigBaKSigBaKSigBaKSigAoopDQAGm0tIaAENJRRQAUGiimIaajNSP0qOmISilooAKSinBSaAG0UpGDSUAFFFFABRRRQAUUUtABRRRQAUUUUAO5opTSD3oAKXNJRQAc0GjNHWgAFLSDg0poATvS0maXGaAFHSkNBoFAAKKSgdaAFpOppaVaQDcHNSpxSAc08CgY7NFJRSGFFFIKAHUUUlAC0lFFABRRSGgBaKSigBaQ0Gmk0ALQaQGigBDSUppKAFFKaTNNck8UxDWOTScUUoVm6UxCUoQtUgQDrS59KAECAdaCeeKWjigCButJUkoqOgAooooAKKKKAClpKUUAFFBooAKKKKAH0hoJpeKAE4Aoo4oHWgAox60ZooAWlPSkpc8UAJj2pelIcg0ueOaAEOMZpAadimmgBeDRikzT1HrQAgFLilpaQCqKdSAUtAwpKKKQwo6c0lNlbAApiHhqXrUAf1qUNxQwFNGaSikMWkoooAAaU03NNdvlpiFL0A5qJmyABTozzigB9FFFIYlLRS0AJikIzS0CmIQIByafn0pKWmIQ0UUtACUUtLigBjLkVCRirOKjlTuKAIaKKKACiiigAooooAWiikoAWihRk0pGDQA7F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',
            'created_at' => now(),
            'updated_at' => now()
        ])->assignRole(['AppUser']);

        User::create([
            'nickname' => 'Mari',
            'email' => 'mari@review.com',
            'password' => Hash::make('Mari123.'),
            'name' => 'Maribel',
            'last_name' => 'Hs',
            'address' => 'Monterrey',
            'phone' => '1234567890',
            'image' => '/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAFA3PEY8MlBGQUZaVVBfeMiCeG5uePWvuZHI////////////////////////////////////////////////////2wBDAVVaWnhpeOuCguv/////////////////////////////////////////////////////////////////////////wAARCADzAM8DASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwCXyIv7go8iL+4KkopFEfkRf3BR5EX9wVJSMwUZPAoAZ5EX9wUeRF/cFPBB5ByKWgCP7PF/cFHkRf3BUlFAiPyIv7go8iL+4KkooAia3jIOEAqs8QRsECr1NkQOuD1oAqIsZ4ZRUnlR/wB0VG6lGwafHJ2NADvKj/uCjyo/7gp2aWgBnkx/3BR5Mf8AdFPooAZ5Mf8AdFHkx/3RT6KAGeTH/cFHlR/3BT6KAGeTH/cFHlR/3BTs0ZoAb5Uf90UeVH/dFOJA6mo2lHbmgC1SUUUDCkYZUilooAjDEVIGyKiOAxGKTO08dKBE9FMVgfxp9ABRRRQMKKKKBDXQOuDVR0KNg1dproHXBoAqo/YmpqruhRsGnJJj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',
            'created_at' => now(),
            'updated_at' => now()
        ])->assignRole(['AppUser']);

    }
}